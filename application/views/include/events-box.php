<?php /*
<style>
   .dw-event{width: 400px;max-width: 100%;margin: 0 auto;float: none;box-shadow: -2px 5px 8px 1px #9E9E9E;border-radius: 5px;}
   .dw-event .dw-event-head{background-color: #339999;padding: 15px;border-top-left-radius: 5px;border-top-right-radius: 5px;}
   #box-events #close-form{
      float: right;
      position: relative;
      top: -50px;
      border: none;
      background: rgba(255, 255, 255, 0);
      font-weight: bold;
      font-size: 20px;
      outline: none;
      right: -10px;
   }
   .dw-event .dw-event-head h4{color: #fff;font-size: 16px;}
   .dw-event .dw-event-body{padding: 15px;background-color: #fff;border-bottom-right-radius: 5px;border-bottom-left-radius: 5px;}
   .dw-event-body .tab-content{margin-bottom: 20px}
   .dw-event-body .nav{border: none;border-bottom: 3px solid #a3a3a3;padding-bottom: 13px;}
   .dw-event-body .nav a span{font-size: 14px;color: #99281e;}
   .dw-event-body .nav a, .dw-event-body .nav a:hover{padding: 5px 25px 0 0;border: none!important;background-color: #fff;color: #383636;font-size: 14px;}
   .dw-event-body .nav .active a{color: #339999!important;}
   .dw-event-body .dw-event-body-Upcoming{margin: 20px 0;position: relative;}
   .dw-event-body .dw-event-body-Upcoming .dw-calenda{position: absolute;border: none;padding: 0;background-color: #fff;outline: none;top: 0;right: 0;}
   .dw-event-body .dw-event-body-Upcoming .dw-calenda img{width: 20px;height: auto;}
   .dw-event-body .dw-event-body-Upcoming .name{margin: 0 0 10px 0!important;color: #282727;font-size: 16px;text-decoration: none;}
   .dw-event-body .dw-event-body-Upcoming p{text-align: justify;margin-bottom: 8px;font-size: 16px;line-height: 1.3;}
   .color-event{color: #ff9800}
   .button-dw-event{text-align: right;}
   .button-dw-event .btn{padding: 7px 20px;border-radius: 3px;font-size: 16px;}
   .button-dw-event .ignore, .button-dw-event .ignore:hover, .button-dw-event .ignore:focus{border: 1px solid #000;color: #000;background-color: #fff;outline: none;}
   .button-dw-event .maybe, .button-dw-event .maybe:hover, .button-dw-event .maybe:focus{border: 1px solid #ff9800;color:#ff9800;background-color: #fff;outline: none;}
   .button-dw-event .going, .button-dw-event .going:hover, .button-dw-event .going:focus{background-color: #339999;color: #fff;border-color: #339999;outline: none;}
   .dw-image{position: relative;width: 115px;height: 115px;text-align: center;margin-bottom: 3px;}
   .dw-image .image img{width: 100%;height: 100%;}
   .dw-image .child-dw-image p{text-align: center!important;color: #fff;padding-top: 22px;font-size: 17px;}
   .dw-image .child-dw-image h1{margin: 0;color: #fff;font-size: 40px;}
   .dw-image .child-dw-image{position: absolute;width: 100%;height: 100%;top: 0;left: 0;background-color: rgba(0, 0, 0, 0.45);}
   a.child-dw-image:hover,a.child-dw-image:focus{text-decoration: none;}
   .child-dw-image figure{position: relative;width: 100%;height: 100%;}
   .child-dw-image figure::before{
   position: absolute;
   top: 50%;
   left: 50%;
   z-index: 2;
   display: block;
   content: '';
   width: 0;
   height: 0;
   background: rgba(255,255,255,.2);
   border-radius: 100%;
   -webkit-transform: translate(-50%, -50%);
   transform: translate(-50%, -50%);
   opacity: 0;
   }
   .child-dw-image figure:hover::before{
   text-decoration: none;
   animation: circle .75s;
   -webkit-animation: circle .75s;
   }
   @-webkit-keyframes circle {
   0% {
   opacity: 1;
   }
   40% {
   opacity: 1;
   }
   100% {
   width: 200%;
   height: 200%;
   opacity: 0;
   }
   }
   @keyframes circle {
   0% {
   opacity: 1;
   }
   40% {
   opacity: 1;
   }
   100% {
   width: 200%;
   height: 200%;
   opacity: 0;
   }
   }
   .event-near-you .col-left{padding: 0 0 0 15px;}
   .event-near-you .col-content{padding: 0 10px 0 10px;}
   .event-near-you .col-right{padding: 0 15px 0 0;}
   .event-near-you{border-top: 3px solid #a3a3a3;}
   .event-near-you .dw-image{width: 100%;height: auto;}
   .event-near-you .dw-image .image img{width: 100%;height: 70px;}
   .event-near-you .btn-link{font-size: 18px;color: #399;}
   .event-near-you h4{color: #282727;}
   .event-near-you .col-left-sm{padding: 0 0 0 15px;}
   .event-near-you .col-right-sm{padding: 0px 15px 0 5px;}
   .event-near-you .thumbnail{padding: 0}
   .media-body a{color: #000;}
   .thumbnail>img{width: 100%;display: block;}
   .event-near-you .caption p{border-bottom: 3px solid #a3a3a3;padding-bottom: 10px;font-size: 14px;}
   .caption p:last-child{border: none;}
   .caption .calenda .day{color: #000;}
   .caption .calenda .month{color: #cc6666;}
   .btn-xs-link{font-size: 12px!important;color: #9E9E9E!important}
   .caption .btn-xs-link .fa{font-size: 25px;}
   .caption .btn-xs-link span{position: relative;top: -4px;left: 10px;font-size: 12px;}
   #box-events #close-form{color: #000 !important; font-weight: bold;}
   @media screen and (max-width: 360px) {
   .event-near-you .dw-image .child-dw-image p{
   padding: 17px;
   line-height: 1;
   }
   }
   @media screen and (max-width: 480px){
   .button-dw-event .btn{padding: 7px 12px;font-size: 14px;}
   }
</style>
<div id="box-events">
    <div class="dw-event">
   <div class="dw-event-head">
      <h4>Events</h4>
      <a href="#" id="close-form">x</a>
   </div>
   <div class="dw-event-body">
      <ul class="nav nav-tabs">
         <li class="active"><a data-toggle="tab" href="#Upcoming">Upcoming</a></li>
         <li><a data-toggle="tab" href="#Invites">Invites <span>2</span></a></li>
         <li><a data-toggle="tab" href="#Hosting">Hosting</a></li>
         <li><a data-toggle="tab" href="#PastEvents">Past Events</a></li>
      </ul>
      <!-- tab-content -->
      <div class="tab-content">
         <!-- Upcoming -->
         <div id="Upcoming" class="tab-pane fade in active">
            <!--list dw-event-body-Upcoming -->
            <div class="dw-event-body-Upcoming">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="dw-image">
                        <div class="image">
                           <img src="http://beta.dezignwall.com/uploads/company/8e3ef24171679c01518e6b832aa07773_59001f04152ae.png">
                        </div>
                        <a href="#" class="child-dw-image">
                           <figure>
                              <p>May</p>
                              <h1>20</h1>
                           </figure>
                        </a>
                     </div>
                  </div>
                  <div class="col-sm-8">
                     <a href="#" class="name remove-margin">Event Name</a>
                     <p>Sat, May 20 at 9pm</p>
                     <p>Lorem ipsum dolor sit amet, consec on tetur adipis ullamco ...</p>
                     <p>You're interested</p>
                  </div>
               </div>
               <button class="dw-calenda"><img src="http://beta.dezignwall.com/skins/icon/dw-calenda.png"></button>
            </div>
            <div class="dw-event-body-Upcoming">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="dw-image">
                        <div class="image">
                           <img src="http://beta.dezignwall.com/uploads/company/8e3ef24171679c01518e6b832aa07773_59001f04152ae.png">
                        </div>
                        <a href="#" class="child-dw-image">
                           <figure>
                              <p>May</p>
                              <h1>20</h1>
                           </figure>
                        </a>
                     </div>
                  </div>
                  <div class="col-sm-8">
                     <a href="#" class="name remove-margin">Event Name</a>
                     <p>Sat, May 20 at 9pm</p>
                     <p>Lorem ipsum dolor sit amet, consec on tetur adipis ullamco ...</p>
                     <p>You're interested</p>
                  </div>
               </div>
            </div>
            <div class="button-dw-event">
               <button class="btn btn-md btn-default ignore">Ignore</button>
               <button class="btn btn-default maybe">Maybe</button>
               <button class="btn btn-default going">Going</button>
            </div>
            <!--close list dw-event-body-Upcoming -->
            <!--list dw-event-body-Upcoming -->
            <div class="dw-event-body-Upcoming">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="dw-image">
                        <div class="image">
                           <img src="http://beta.dezignwall.com/uploads/company/8e3ef24171679c01518e6b832aa07773_59001f04152ae.png">
                        </div>
                        <a href="#" class="child-dw-image">
                           <figure>
                              <p>May</p>
                              <h1>20</h1>
                           </figure>
                        </a>
                     </div>
                  </div>
                  <div class="col-sm-8">
                     <a href="#" class="name remove-margin">Event Name</a>
                     <p>Sat, May 20 at 9pm</p>
                     <p>Lorem ipsum dolor sit amet, consec on tetur adipis ullamco ...</p>
                     <p>You're interested</p>
                  </div>
               </div>
               <button class="dw-calenda"><img src="http://beta.dezignwall.com/skins/icon/dw-calenda.png"></button>
            </div>
            <div class="dw-event-body-Upcoming">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="dw-image">
                        <div class="image">
                           <img src="http://beta.dezignwall.com/uploads/company/8e3ef24171679c01518e6b832aa07773_59001f04152ae.png">
                        </div>
                        <a href="#" class="child-dw-image">
                           <figure>
                              <p>May</p>
                              <h1>20</h1>
                           </figure>
                        </a>
                     </div>
                  </div>
                  <div class="col-sm-8">
                     <a href="#" class="name remove-margin">Event Name</a>
                     <p>Sat, May 20 at 9pm</p>
                     <p>Lorem ipsum dolor sit amet, consec on tetur adipis ullamco ...</p>
                     <p>You're interested</p>
                  </div>
               </div>
            </div>
            <div class="button-dw-event">
               <button class="btn btn-default ignore">Can't Go</button>
               <button class="btn btn-default maybe">Maybe</button>
               <button class="btn btn-default going">Going</button>
            </div>
            <!--close list dw-event-body-Upcoming -->
            <!--list dw-event-body-Upcoming -->
            <div class="dw-event-body-Upcoming">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="dw-image">
                        <div class="image">
                           <img src="http://beta.dezignwall.com/uploads/company/8e3ef24171679c01518e6b832aa07773_59001f04152ae.png">
                        </div>
                        <a href="#" class="child-dw-image">
                           <figure>
                              <p>May</p>
                              <h1>20</h1>
                           </figure>
                        </a>
                     </div>
                  </div>
                  <div class="col-sm-8">
                     <a href="#" class="name remove-margin">Event Name</a>
                     <p>Sat, May 20 at 9pm</p>
                     <p>Lorem ipsum dolor sit amet, consec on tetur adipis ullamco ...</p>
                     <p class="color-event">You're hosting this events...</p>
                  </div>
               </div>
               <button class="dw-calenda"><img src="http://beta.dezignwall.com/skins/icon/dw-calenda.png"></button>
            </div>
            <div class="button-dw-event">
               <button class="btn btn-md btn-default ignore">Cancel</button>
               <button class="btn btn-default maybe">Edit</button>
               <button class="btn btn-default going">Promote</button>
            </div>
            <!--close list dw-event-body-Upcoming -->
         </div>
         <!--close Upcoming -->
         <div id="Invites" class="tab-pane fade">
            <div class="dw-event-body-Upcoming">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="dw-image">
                        <div class="image">
                           <img src="http://beta.dezignwall.com/uploads/company/8e3ef24171679c01518e6b832aa07773_59001f04152ae.png">
                        </div>
                        <a href="#" class="child-dw-image">
                           <figure>
                              <p>May</p>
                              <h1>20</h1>
                           </figure>
                        </a>
                     </div>
                  </div>
                  <div class="col-sm-8">
                     <a href="#" class="name remove-margin">Event Name</a>
                     <p>Sat, May 20 at 9pm</p>
                     <p>Lorem ipsum dolor sit amet, consec on tetur adipis ullamco ...</p>
                     <p>You're interested</p>
                  </div>
               </div>
            </div>
            <div class="dw-event-body-Upcoming">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="dw-image">
                        <div class="image">
                           <img src="http://beta.dezignwall.com/uploads/company/8e3ef24171679c01518e6b832aa07773_59001f04152ae.png">
                        </div>
                        <a href="#" class="child-dw-image">
                           <figure>
                              <p>May</p>
                              <h1>20</h1>
                           </figure>
                        </a>
                     </div>
                  </div>
                  <div class="col-sm-8">
                     <a href="#" class="remove-margin">Event Name</a>
                     <p>Sat, May 20 at 9pm</p>
                     <p>Lorem ipsum dolor sit amet, consec on tetur adipis ullamco ...</p>
                     <p>You're interested</p>
                  </div>
               </div>
            </div>
         </div>
         <div id="Hosting" class="tab-pane fade">
            <div class="dw-event-body-Upcoming">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="dw-image">
                        <div class="image">
                           <img src="http://beta.dezignwall.com/uploads/company/8e3ef24171679c01518e6b832aa07773_59001f04152ae.png">
                        </div>
                        <a href="#" class="child-dw-image">
                           <figure>
                              <p>May</p>
                              <h1>20</h1>
                           </figure>
                        </a>
                     </div>
                  </div>
                  <div class="col-sm-8">
                     <a href="#" class="name remove-margin">Event Name</a>
                     <p>Sat, May 20 at 9pm</p>
                     <p>Lorem ipsum dolor sit amet, consec on tetur adipis ullamco ...</p>
                     <p>You're interested</p>
                  </div>
               </div>
            </div>
            <div class="dw-event-body-Upcoming">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="dw-image">
                        <div class="image">
                           <img src="http://beta.dezignwall.com/uploads/company/8e3ef24171679c01518e6b832aa07773_59001f04152ae.png">
                        </div>
                        <a href="#" class="child-dw-image">
                           <figure>
                              <p>May</p>
                              <h1>20</h1>
                           </figure>
                        </a>
                     </div>
                  </div>
                  <div class="col-sm-8">
                     <a href="#" class="name remove-margin">Event Name</a>
                     <p>Sat, May 20 at 9pm</p>
                     <p>Lorem ipsum dolor sit amet, consec on tetur adipis ullamco ...</p>
                     <p>You're interested</p>
                  </div>
               </div>
            </div>
         </div>
         <div id="PastEvents" class="tab-pane fade">
            <div class="dw-event-body-Upcoming">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="dw-image">
                        <div class="image">
                           <img src="http://beta.dezignwall.com/uploads/company/8e3ef24171679c01518e6b832aa07773_59001f04152ae.png">
                        </div>
                        <a href="#" class="child-dw-image">
                           <figure>
                              <p>May</p>
                              <h1>20</h1>
                           </figure>
                        </a>
                     </div>
                  </div>
                  <div class="col-sm-8">
                     <a href="#" class="name remove-margin">Event Name</a>
                     <p>Sat, May 20 at 9pm</p>
                     <p>Lorem ipsum dolor sit amet, consec on tetur adipis ullamco ...</p>
                     <p>You're interested</p>
                  </div>
               </div>
            </div>
            <div class="dw-event-body-Upcoming">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="dw-image">
                        <div class="image">
                           <img src="http://beta.dezignwall.com/uploads/company/8e3ef24171679c01518e6b832aa07773_59001f04152ae.png">
                        </div>
                        <a href="#" class="child-dw-image">
                           <figure>
                              <p>May</p>
                              <h1>20</h1>
                           </figure>
                        </a>
                     </div>
                  </div>
                  <div class="col-sm-8">
                     <a href="#" class="name remove-margin">Event Name</a>
                     <p>Sat, May 20 at 9pm</p>
                     <p>Lorem ipsum dolor sit amet, consec on tetur adipis ullamco ...</p>
                     <p>You're interested</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- tab-content -->
      <!-- event-near-you -->
      <div class="event-near-you">
         <h4>Events near you</h4>
         <div class="row">
            <div class="col-xs-4 col-left">
               <div class="dw-image">
                  <div class="image">
                     <img src="http://beta.dezignwall.com/uploads/company/8e3ef24171679c01518e6b832aa07773_59001f04152ae.png">
                  </div>
                  <a href="#" class="child-dw-image">
                     <figure>
                        <p>To day</p>
                     </figure>
                  </a>
               </div>
            </div>
            <div class="col-xs-4 col-content">
               <div class="dw-image">
                  <div class="image">
                     <img src="http://beta.dezignwall.com/uploads/company/8e3ef24171679c01518e6b832aa07773_59001f04152ae.png">
                  </div>
                  <a href="#" class="child-dw-image">
                     <figure>
                        <p>This week</p>
                     </figure>
                  </a>
               </div>
            </div>
            <div class="col-xs-4 col-right">
               <div class="dw-image">
                  <div class="image">
                     <img src="http://beta.dezignwall.com/uploads/company/8e3ef24171679c01518e6b832aa07773_59001f04152ae.png">
                  </div>
                  <a href="#" class="child-dw-image">
                     <figure>
                        <p>Next month</p>
                     </figure>
                  </a>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-sm-12 text-right"><a href="#" class="btn btn-link">MORE</a></div>
         </div>
      </div>
      <!--close event-near-you -->
      <div class="event-near-you">
         <h4>Popular with friends</h4>
         <div class="row">
            <div class="col-sm-12">
               <div class="thumbnail remove-margin">
                  <img src="http://beta.dezignwall.com/skins/images/event-image.png" alt="image">
                  <div class="caption text-center">
                     <p class="remove-margin text-left">Sarah and 7 friends</p>
                     <div class="media text-left">
                        <div class="media-left calenda text-center">
                           <h1 class="remove-margin day">15</h1>
                           <h4 class="remove-margin month">Jun</h4>
                        </div>
                        <div class="media-body">
                           <a href="#" class="media-heading">Event Name</a>
                           <p class="remove-margin">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor ...</p>
                        </div>
                     </div>
                     <button class="btn btn-link btn-xs-link"><img src="http://beta.dezignwall.com/skins/icon/calenda-style.png"> Interested</button>
                     <button class="btn btn-link btn-xs-link"><img src=""><i class="fa fa-share-alt"></i> <span>Share</span></button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
*/ ?>