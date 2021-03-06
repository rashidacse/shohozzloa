<script>
    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
    function numberValidation(phoneNumber) {
        var regexp = /^((^\880|0)[1][1|5|6|7|8|9])[0-9]{8}$/;
        var validPhoneNumber = phoneNumber.match(regexp);
        if (validPhoneNumber) {
            return true;
        }
        return false;
    }
    function create_reseller(resellerInfo) {
        if (typeof resellerInfo.username == "undefined" || resellerInfo.username.length == 0) {
            $("#content").html("Please give a User Name !");
            $('#common_modal').modal('show');
            return;
        }
        if (typeof resellerInfo.password == "undefined" || resellerInfo.password.length == 0) {
            $("#content").html("Please give Password  !");
            $('#common_modal').modal('show');
            return;
        }

        if (typeof resellerInfo.mobile != "undefined" && resellerInfo.mobile.length != 0) {
            var varificationResult = numberValidation(resellerInfo.mobile);
            if (varificationResult == false) {
                $("#content").html("Please give Mobile Number ! Supported format is now 01XXXXXXXXX");
                $('#common_modal').modal('show');
                return;
            }
        }
        if (typeof resellerInfo.email != "undefined" && resellerInfo.email.length != 0) {
            var varificationResult = validateEmail(resellerInfo.email);
            if (varificationResult == false) {
                $("#content").html("Please Enter a valid Email Address! Supported format is example@mail.com");
                $('#common_modal').modal('show');
                return;
            }
        }
        angular.element($('#submit_create_reseller')).scope().createReseller(function (data) {
            $("#content").html(data.message);
            $('#common_modal').modal('show');
            $('#modal_ok_click_id').on("click", function () {
                window.location = '<?php echo base_url() ?>reseller/get_reseller_list';
            });
        });


    }

</script>

<div class="loader"></div>
<div class="ezttle"><span class="text"><?php echo $title; ?></span></div>
<div class="mypage" ng-controller="resellerController">
    <div class="top10">&nbsp;</div>
    <div class="row" ng-init="createResellerInitialize('<?php echo DEFAULT_PIN ?>')">
        <div class="col-md-12 fleft">	
            <?php // echo form_open("reseller/create_reseller", array('id' => 'form_create_reseller', 'class' => 'inform well', 'style' => 'width:650px;')); ?>
            <ng-from>    
                <input type="hidden" style="display:none;" value="" name="elctkn">
                <table style="width:100%;">
                    <tbody>
                        <tr>
                            <?php echo $message; ?>
                        </tr>
                        <tr>
                            <td style="width:50%;vertical-align:top;padding-right:15px;">
                                <p class="help-block">Create Reseller</p>
                                <div class="form-group ">
                                    <label for="username" class="control-label">Username<span style="color:red">*</span></label>
                                    <input type="text" value="" placeholder="Username" class="form-control input-sm" id="username" name="username" ng-model="resellerInfo.username">
                                    <p class="help-block form_error"></p>
                                </div>
                                <div class="form-group ">
                                    <label for="password" class="control-label">Password<span style="color:red">*</span></label>
                                    <input type="password" autocomplete="off" value="" placeholder="Password" class="form-control input-sm" id="password" name="password" ng-model="resellerInfo.password">
                                    <p class="help-block form_error"></p>
                                </div>
                                <div class="form-group ">
                                    <label for="name" class="control-label">First name</label>
                                    <input type="text" value="" placeholder="First name" class="form-control input-sm" id="first_name" name="first_name" ng-model="resellerInfo.first_name">
                                    <p class="help-block form_error"></p>
                                </div>
                                <div class="form-group ">
                                    <label for="name" class="control-label">Last name</label>
                                    <input type="text" value="" placeholder="Last name" class="form-control input-sm" id="last_name" name="last_name" ng-model="resellerInfo.last_name">
                                    <p class="help-block form_error"></p>
                                </div>
                                <div class="form-group ">
                                    <label for="mobile" class="control-label">Mobile Number</label>
                                    <input type="text" value="" placeholder="01XXXXXXXXX" class="form-control input-sm" id="mobile" name="mobile" ng-model="resellerInfo.mobile">
                                    <p class="help-block form_error"></p>
                                </div>
                                <div class="form-group ">
                                    <label for="email" class="control-label">Email</label>
                                    <input type="text" value="" placeholder="Email" class="form-control input-sm" id="email" name="email" ng-model="resellerInfo.email">
                                    <p class="help-block form_error"></p>
                                </div>
                                <div class="form-group ">
                                    <label for="max_no" class="control-label">Max Allowable Users No</label>
                                    <input type="text" value="" placeholder="Maximum Allowable Users No" class="form-control input-sm" id="max_user_no" name="max_user_no" ng-model="resellerInfo.max_user_no">
                                    <p class="help-block form_error"></p>
                                </div>
                                <div class="form-group ">
                                    <label for="note">Note</label>
                                    <textarea rows="2" name="note" id="note" class="form-control input-sm" ng-model="resellerInfo.note"></textarea>
                                    <p class="help-block form_error"></p>
                                </div>
                            </td>
                            <td style="width:50%;vertical-align:top;padding-left:15px;">
                                <p style="padding:0px;" class="help-block">
                                    <!--<input type="checkbox" onclick="checkallper(this);" ng-click="" value="1" id="allper" name="checkAll">--> 
                                    <input type="checkbox" ng-model="selectedAll" ng-click="checkAll()" />
                                    <label for="allper" style="cursor:pointer;">Reseller Permission</label> </p>
                                <div class="form-group" ng-init="setServiceList('<?php echo htmlspecialchars(json_encode($service_list)); ?>')">
                                    <div ng-repeat="serviceInfo in serviceList">
                                        <div class="checkbox" ng-if="serviceInfo.status == 1">
                                            <label>
                                                <input type="checkbox"  ng-model="serviceInfo.selected" value="{{serviceInfo.id}}" name="per[]"  ng-click="toggleSelection(serviceInfo)">{{serviceInfo.title}}
                                            </label>
                                        </div>
                                    </div>
                                    <p class="help-block form_error"></p>
                                </div>
                                <div class="form-group ">
                                    <label for="pin" class="control-label">Pin</label>
                                    <input type="password" value="" placeholder="" class="form-control input-sm" id="pin" name="pin" ng-model="resellerInfo.pin">
                                    <p class="help-block form_error"></p>
                                </div>
                                <div class="form-group ">
                                    <label for="balance" class="control-label">Starting Balance</label>
                                    <input type="text" value="" placeholder="" class="form-control input-sm" id="init_balance" name="init_balance" ng-model="resellerInfo.init_balance">
                                    <p class="help-block form_error"></p>
                                </div>
                                <div class="form-group ">
                                    <label for="message">Message</label>
                                    <textarea rows="2" name="message" id="note" class="form-control input-sm" ng-model="resellerInfo.message"></textarea>
                                    <p class="help-block form_error"></p>
                                </div>
                                <p style="padding-top: 0px !important;padding-top: 0px !important;line-height:0px;" class="help-block">&nbsp;</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="help-block line">&nbsp;</p>
                <input id="submit_create_reseller" name="submit_create_reseller" class="btn btn-primary btn-sm" type="submit" onclick="create_reseller(angular.element(this).scope().resellerInfo)" value="Add Reseller"/>
            </ng-from>
            <?php // echo form_close(); ?>
        </div> 
    </div> 
</div>