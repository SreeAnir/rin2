 <!-- Modal -->
 <div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Verify Otp</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">

                 <div class="form-group row">
                    <label for="email" class="col-sm-12 col-form-label">Please enter the OTP Code recieved on the phone number provided.</label>
                    <div class="col-sm-6 mx-auto">
                        <input type="text" class="form-control "
                            id="otp"
                            name="otp" placeholder="0 - 0 - 0 - 0 - 0 - 0">
                    </div>
                </div>

             </div>
             <div class="modal-footer">
                 <button style="display: none;" id="resendOtp" type="button" class="btn btn-secondary"
                    >Resend</button>
                 <button disabled id="confirmOtp" type="button" class="btn btn-primary">Confirm Otp</button>
             </div>
         </div>
     </div>
 </div>
