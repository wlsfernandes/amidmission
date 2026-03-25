 <!--Contact Info Section Here-->
 <div class="contact__info__section pt-130 pb-130 section__bg overhid">
     @if (session('success'))
         <div class="alert alert-success">
             {{ session('success') }}
         </div>
     @endif
     <div class="container">
         <div class="row g-5 align-items-center">
             <div class="col-lg-7">
                 <div class="contact__right">
                     <div class="info__header">
                         <h6>@lang('pages.have_questions')</h6>
                         <div class="witr_bar_main">
                             <div class="witr_bar_inner witr_bar_innerc">
                             </div>
                         </div>
                         <p>
                             @lang('pages.send_message')
                         </p>
                     </div>
                     <form action="{{ route('contact.send') }}" method="POST">
                         @csrf
                         {{-- Honeypot Field (hidden bot trap) --}}
                         <input type="text" name="website" style="display:none">
                         <div class="row g-4">
                             <div class="col-lg-12">
                                 <div class="form__clt">
                                     <input type="text" name="name" id="name"
                                         placeholder="@lang('pages.your_name')">
                                 </div>
                             </div>
                             <div class="col-lg-6">
                                 <div class="form__clt">
                                     <input type="text" name="email" id="email"
                                         placeholder="@lang('pages.your_email')">
                                 </div>
                             </div>
                             <div class="col-lg-6">
                                 <div class="form__clt">
                                     <input type="text" name="number" id="number"
                                         placeholder="@lang('pages.your_phone')">
                                 </div>
                             </div>
                             <div class="col-lg-12">
                                 <div class="form__clt__big">
                                     <textarea name="message" id="message" placeholder="@lang('pages.your_message')"></textarea>
                                 </div>
                             </div>
                             <div class="col-lg-4">
                                 <button type="submit" class="cmn--btn">
                                     <i class="fa-solid fa-paper-plane"></i> @lang('pages.send')
                                 </button>
                             </div>
                         </div>

                     </form>
                 </div>
             </div>
             <div class="col-lg-5">
                 <div class="left__info">
                     <div class="left__header">
                         <h3>@lang('pages.contact_information')</h3>
                         <p>
                             @lang('pages.contact_information_description')
                         </p>
                     </div>
                     
                     <div class="info__wrap d-flex align-items-center mt-4">
                         <div class="icon">
                             <i class="fa-solid fa-location-dot"></i>
                         </div>
                         <div class="content">
                             <h6>
                                 @lang('pages.office_address')
                             </h6>
                             <p>
                                  P.O. Box 580527, Kissimmee, FL 34758
                             </p>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!--Contact Info Section End-->
