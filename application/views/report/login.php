<div class="wrap">
                <div class="row">
                  <div class="full-width">
                   <form action="/report/login" method="post">
                     <div class="form-group">
                        <label for="exampleInputEmail1">User Name</label>
                        <input type="text" name="user"  class="form-control" placeholder="User Name" required="required">
                     </div>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password" name="password"  class="form-control" placeholder="Password" required="required">
                     </div>
                     <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
</div>
</body>
</html>
              <style>
                  .wrap{
                    margin:0 auto;
                    width:300px;
                    max-width:100%;
                  }
                  .row {
                      margin: 0 auto;
                      max-width: 120em;
                      width: 100%;
                      border: 1px solid #ccc;
                      padding: 20px 10px;
                  }
                  .row:before, .row:after {
                      content: " ";
                      display: table;
                  }
                  .row:after {
                      clear: both;
                  }
                  .full-width{
                    float:left;
                    width:100%;
                  }
                  .form-group label{
                    display: block;
                  }
                  .form-group input{
                    height: 25px;
                    margin-bottom: 12px;
                    width: 100%;
                  }
                  .btn {
                      display: inline-block;
                      margin-bottom: 0;
                      font-weight: normal;
                      text-align: center;
                      vertical-align: middle;
                      -ms-touch-action: manipulation;
                      touch-action: manipulation;
                      cursor: pointer;
                      background-image: none;
                      border: 1px solid transparent;
                      white-space: nowrap;
                      padding: 6px 12px;
                      font-size: 14px;
                      line-height: 1.42857143;
                      border-radius: 4px;
                      -webkit-user-select: none;
                      -moz-user-select: none;
                      -ms-user-select: none;
                      user-select: none;
                  }
                  .btn-primary {
                      color: #ffffff;
                      background-color: #337ab7;
                      border-color: #2e6da4;
                  }
              </style>