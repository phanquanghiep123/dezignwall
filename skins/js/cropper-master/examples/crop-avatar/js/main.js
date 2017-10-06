(function (factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as anonymous module.
    define(['jquery'], factory);
  } else if (typeof exports === 'object') {
    // Node / CommonJS
    factory(require('jquery'));
  } else {
    // Browser globals.
    factory(jQuery);
  }
})(function ($) {

  'use strict';

  var console = window.console || { log: function () {} };

  function CropAvatar($element) {
    this.$container     = $element;
    this.$avatarView    = this.$container.find('.avatar-view');
    this.$avatar        = this.$avatarView.find('img');
    this.$avatarModal   = this.$container.find('#avatar-modal');
    this.$loading       = this.$container.find('.loading');
    this.$avatarForm    = this.$avatarModal.find('.avatar-form');
    this.$avatarUpload  = this.$avatarForm.find('.avatar-upload');
    this.$avatarSrc     = this.$avatarForm.find('.avatar-src');
    this.$avatarData    = this.$avatarForm.find('.avatar-data');
    this.$avatarInput   = this.$avatarForm.find('.avatar-input');
    this.$avatarSave    = this.$avatarForm.find('.avatar-save');
    this.$avatarBtns    = this.$avatarForm.find('.avatar-btns');
    this.$avatarWrapper = this.$avatarModal.find('.avatar-wrapper');
    this.$avatarPreview = this.$avatarModal.find('.avatar-preview');
    this.$canvas        = this.$avatarModal.find('#create_img')[0];
    this.width          = 0;
    this.height         = 0;
    this.$jcrop         = null;
    this.init();
  }

  CropAvatar.prototype = {
    constructor: CropAvatar,
    support: {
      fileList: !!$('<input type="file">').prop('files'),
      blobURLs: !!window.URL && URL.createObjectURL,
      formData: !!window.FormData
    },
    init: function () {
      this.support.datauri = this.support.fileList && this.support.blobURLs;

      if (!this.support.formData) {
        this.initIframe();
      }

      this.initTooltip();
      this.initModal();
      this.addListener();
    },
    addListener: function () {
      var _this = this;
      this.$avatarView.on('click',function(){
        _this.$avatar = $(this);
        if(_this.$avatar.attr("data-type") == "avatar"){
          _this.$avatarModal.find(".modal-title").html("Change your avatar");
        }else{
          _this.$avatarModal.find(".modal-title").html("Change your banner");
        }
        _this.$avatarModal.find("#avatarInput").trigger("click");
        //_this.click();
      });
      this.$avatarInput.on('change', $.proxy(this.change, this));
      this.$avatarForm.on('submit', $.proxy(this.submit, this));
      this.$avatarBtns.on('click', $.proxy(this.rotate, this));
    },

    initTooltip: function () {
      this.$avatarView.tooltip({
        placement: 'bottom'
      });
    },

    initModal: function () {
      this.$avatarModal.modal({
        show: false
      });
    },

    initPreview: function () {
      var _this = this;
      _this.$avatarModal.find(".loading").show();
      _this.$avatarModal.find(".avatar-wrapper").css("opacity",0);
      setTimeout(function(){
        _this.startCropper();
        _this.$avatarModal.find(".loading").hide();
      },1000);
      
    },

    initIframe: function () {
      var target = 'upload-iframe-' + (new Date()).getTime();
      var $iframe = $('<iframe>').attr({
            name: target,
            src: ''
          });
      var _this = this;

      // Ready ifrmae
      $iframe.one('load', function () {

        // respond response
        $iframe.on('load', function () {
          var data;

          try {
            data = $(this).contents().find('body').text();
          } catch (e) {
            console.log(e.message);
          }

          if (data) {
            try {
              data = $.parseJSON(data);
            } catch (e) {
              console.log(e.message);
            }

            _this.submitDone(data);
          } else {
            _this.submitFail('Image upload failed!');
          }

          _this.submitEnd();

        });
      });

      this.$iframe = $iframe;
      this.$avatarForm.attr('target', target).after($iframe.hide());
    },

    click: function () {
      this.$avatarModal.modal('show');
      this.initPreview();
    },

    change: function () {
      var files;
      var file;
      if (this.support.datauri) {
        files = this.$avatarInput.prop('files');
        if (files.length > 0) {
          file = files[0];
          if (this.isImageFile(file)) {
            if (this.url) {
              URL.revokeObjectURL(this.url); // Revoke the old one
            }
            this.url = URL.createObjectURL(file);
            this.$container.find("#value-image").attr(this.url);
            this.startCropper();
          }
        }
      } else {
        file = this.$avatarInput.val();
        if (this.isImageFile(file)) {
          this.syncUpload();
        }
      }
      this.click();
      
    },

    submit: function () {
      if (this.support.formData) {
        this.ajaxUpload();
        return false;
      }
    },

    rotate: function (e) {
      var data;
      if (this.active) {
        data = $(e.target).data();
        if (data.method) {
          this.$img.cropper(data.method, data.option);
        }
      }
    },

    isImageFile: function (file) {
      if (file.type) {
        return /^image\/\w+$/.test(file.type);
      } else {
        return /\.(jpg|jpeg|png|gif)$/.test(file);
      }
    },

    startCropper: function () {
        var _this = this;
        _this.$avatarWrapper.html('<img id="value-image" src="'+_this.url+'">');
        if (_this.$jcrop != null && typeof _this.$jcrop != 'undefined') {
          _this.$jcrop.destroy();
          _this.$jcrop = null;
        }  
        var aspectRatio ; 
        if(_this.$avatar.attr("data-type") == "avatar"){
          _this.width          = 400;
          _this.height         = 400;
          aspectRatio          = 1 / 1
        }
        if(_this.$avatar.attr("data-type") == "banner"){
          _this.width          = 1200;
          _this.height         = 400;
          aspectRatio          = 3 / 1;
        }  
        console.log([0, 0, _this.height, _this.width]);
        _this.$avatarModal.find("img#value-image").Jcrop({
          setSelect: [0, 0, 400, 1200],
          onChange:  function (c) {
            if(parseInt(c.w) > 0) {
              // Show image preview
              var imageObj  = _this.$avatarWrapper.find("#value-image")[0];
              _this.$canvas.width = c.w;
              _this.$canvas.height = c.h;
              var context   = _this.$canvas.getContext("2d");
              context.drawImage(imageObj, c.x, c.y, c.w, c.h, 0, 0, c.w, c.h);
            }
          },
          onRelease:  function (c) {
            if(parseInt(c.w) > 0) {
              var imageObj  = _this.$avatarWrapper.find("#value-image")[0];
              _this.$canvas.width = c.w;
              _this.$canvas.height = c.h;
              var context   = _this.$canvas.getContext("2d");
              context.drawImage(imageObj, c.x, c.y, c.w, c.h, 0, 0, c.w, c.h);
            }
          },
          aspectRatio: aspectRatio,
          bgColor:     '',
          boxWidth: 830,   //Maximum width you want for your bigger images
        },function () {
            _this.$jcrop = this;
            _this.$avatarModal.find(".avatar-wrapper").css("opacity",1);
        });
    },
    stopCropper: function () {
      var _this =  this;
      if (_this.$jcrop != null && typeof _this.$jcrop != 'undefined') {
        _this.$jcrop.destroy();
        _this.$jcrop = null;
      }  
    },
    ajaxUpload: function () {
      var _this     = this;
      var toDataURL = this.$canvas.toDataURL('image/png');
      var type      = _this.$avatar.attr("data-type");
      this.$avatarModal.find("#colum_change").val(type);
      this.$avatarModal.find("#string_img").val(toDataURL);
      var url = this.$avatarForm.attr('action');
      var data = new FormData(this.$avatarForm[0]);
      $.ajax(url, {
        type: 'post',
        data: data,
        dataType: 'json',
        processData: false,
        contentType: false,
        beforeSend: function () {
          _this.submitStart();
        },

        success: function (data) {
          _this.submitDone(data);
        },

        error: function (XMLHttpRequest, textStatus, errorThrown) {
          _this.submitFail(textStatus || errorThrown);
        },

        complete: function () {
          _this.submitEnd();
        }
      });
    },

    syncUpload: function () {
      this.$avatarSave.click();
    },

    submitStart: function () {
      this.$loading.fadeIn();
    },

    submitDone: function (data) {
      if (data.state === 200) {
        if (data.result) {
          this.url = data.result;
          if (this.support.datauri || this.uploaded) {
            this.uploaded = false;
            this.cropDone();
          } else {
            _this.uploaded = true;
            _this.$avatar.attr("data-img",this.url);
            _this.startCropper();
          }
          this.$avatarInput.val('');
        } else if (data.message) {
          this.alert(data.message);
        }
      } else {
        this.alert('Failed to response');
      }
    },

    submitFail: function (msg) {
      this.alert(msg);
    },

    submitEnd: function () {
      this.$loading.fadeOut();
    },

    cropDone: function () {
      this.$avatarForm.get(0).reset();
      this.$avatar.attr('data-img', this.url);
      this.stopCropper();
      if(this.$avatar.attr("data-type") == "avatar"){
        this.$container.find("img#avatarshow").attr("src",this.url);
        $("#header .avatar-user img").attr("src",this.url);
      } 
      if( this.$avatar.attr("data-type") == "banner" ){
        this.$container.find("img#bannershow").attr("src",this.url);
      }
      this.$avatarModal.modal('hide');
    },
    alert: function (msg) {
      var $alert = [
            '<div class="alert alert-danger avatar-alert alert-dismissable">',
              '<button type="button" class="close" data-dismiss="alert">&times;</button>',
              msg,
            '</div>'
          ].join('');

      this.$avatarUpload.after($alert);
    }
  };

  $(function () {
    return new CropAvatar($('#crop-avatar'));
  });

});
