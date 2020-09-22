@if( $transaction->transLevel_id < 9 && $transaction->b_user_id == Auth::id() )
    <div class="card">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#cancel">
                    <i class="pe-7s-angle-left-circle"></i>
                لغو معامله
                </a>
            </h4>
        </div>
        <div id="cancel" class="content collapse ">
            <div class="row">
                <div class="col-md-12">
                    <ul>
                    <li>
                        لغو معامله تا پایان مرحله سوم (دریافت اطلاعات شما) بدون هیچ دلیلی، امکان پذیر است. پول واریزی شما به سایت در اسرع وقت به حساب شما برگشت داده می شود.
                    </li>
                    <li>
                        از مرحله چهارم تا ششم، لغو معامله فقط با رضایت طرف مقابل امکان پذیر می باشد.
                    </li>
                    <li>
                        از مرحله هفتم تا انتها، لغو معامله امکان پذیر نیست.
                    </li>
                    @if( $transaction->transLevel_id < 7 && $transaction->cancel_flag != 2 )
                        <li>
                            برای لغو معامله دکمه زیر را فشار دهید.
                        </li>
                        </ul>
                        <h3 style="padding-right: 5%">
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#CancelModal">لغو معامله</button>
                        </h3>
                        <!-- Modal content in edit page-->
                    @elseif( $transaction->cancel_flag === 2 )
                    </ul>
                        <p class="text-danger text-center">
                            شما یک بار درخواست لغو را ارسال کردید اما این درخواست رد شد. امکان درخواست مجدد وجود ندارد.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif



