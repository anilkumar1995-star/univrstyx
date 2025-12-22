 <footer>
   <div class="container">
     <div class="d-flex justify-content-between footerLogo">

       <div class="leftLog">
         <img src="{{ asset('') }}frontend/images/I-University_logo_white.png">
         <p>{{ $homepage->building_careers ?? 'Building Careers of Tomorrow' }}</p>
         <div class="socialIcon">
           <ul>
             <li><a href="#"><img src="{{ asset('') }}frontend/images/footer/social/fb.svg"> </a></li>
             <li><a href="#"><img src="{{ asset('') }}frontend/images/footer/social/twitter.svg"> </a></li>
             <li><a href="#"><img src="{{ asset('') }}frontend/images/footer/social/linkedin.svg"> </a></li>
             <li><a href="#"><img src="{{ asset('') }}frontend/images/footer/social/YouTube.svg"> </a></li>
           </ul>
         </div>
       </div>
       <!-- <div class="rightLog">
         <a href="#"> <i class="fa-brands fa-android"></i> get the android app </a>
         <a href="#"> <i class="fa-brands fa-apple"></i> get the android app </a>
       </div> -->

     </div>
     <div class="footerMenu">
       <div class="row">
         <!-- Static iUniversity Section -->
         <div class="col-lg-3">
           <h4 class="footer-title">iUniversity</h4>
           <!-- <div class="col-lg-3">
             <h4 class="footer-title">iUniversity</h4>
             <ul>
               <li><a href="#">About </a></li>
               <li><a href="#">Careers </a></li>
               <li><a href="#">Placement Support </a></li>
               <li><a href="#">iUniversity Blog </a></li>
               <li><a href="#">iUniversity Tutorials </a></li>
               <li><a href="#">Resources </a></li>
               <li><a href="#">iUniversity Free Courses </a></li>
               <li><a href="#">For Teams </a></li>
               <li><a href="#">Data Science Programs for Teams </a></li>
               <li><a href="#">Product and Technology Programs for Teams </a></li>
               <li><a href="#">Management Programs for Teams </a></li>
               <li><a href="#">Online Power Learning </a></li>
               <li><a href="#">Xchange </a></li>
               <li><a href="#">BaseCamp </a></li>
               <li><a href="#">For Business </a></li>
               <li><a href="#">Watch Free Videos </a></li>
               <li><a href="#">iUniversity In Media </a></li>
               <li><a href="#">Reviews </a></li>
             </ul>
           </div> -->
           @if(!empty($aboutUsList) && count($aboutUsList) > 0)
           <ul>
             @foreach($aboutUsList as $about)
             <li>
               <a href="{{ url('footer/about-us/'.$about->id) }}">
                 {{ ucfirst($about->title) }}
               </a>
             </li>
             @endforeach
             @if(!empty($contactUsList) && count($contactUsList) > 0)
             @foreach($contactUsList as $contact)
             <li>
               <a href="{{ url('footer/contact-us/'.$contact->id) }}">
                 {{ ucfirst($contact->heading) }}
               </a>
             </li>
             @endforeach
             @endif
           </ul>
           @else
           <p>No Data found.</p>
           @endif
         </div>


         <!-- Dynamic Support Section -->
         <!-- Dynamic Support Section -->
         <div class="col-lg-3">
           <h4 class="footer-title">Support</h4>

           <ul>
             <!-- Static LI -->
             <li>
               <a href="{{ url('online-grievance') }}">
                 Grievance Redressal
               </a>
             </li>

             @if(!empty($footerCategories))
             @foreach($footerCategories as $index => $cat)
             <li>
               <a href="{{ url('footer/support/'.$index) }}">
                 {{ ucfirst($cat['category_name']) }}
               </a>
             </li>
             @endforeach
             @else
             <li>No support categories found.</li>
             @endif
           </ul>
         </div>



       </div>
     </div>


     <div class="footerMenu">
       <div class="row">
         @foreach ($categories as $category)
         <div class="col-lg-3 mb-4">
           <h4 class="footer-title">
             <a href="{{ url('programmes/'.$category->id) }}" class="text-white">
               {{ $category->degree_category }}
             </a>
           </h4>

           <ul>
             @foreach ($category->universities as $type => $unis)
             @foreach ($unis as $uni)
             <li>
               <a href="{{ url('programme/'.$uni->id) }}" class="text-white">
                 {{ $uni->degree_name ?? $uni->university_name }}
               </a>
             </li>
             @endforeach
             @endforeach
           </ul>
         </div>
         @endforeach

       </div>
     </div>


     <!-- <div class="footerMenu">
       <div class="row">
         <div class="col-lg-3">
           <h4 class="footer-title">
             Job Linked
           </h4>
           <ul>
             <li><a href="#"> Management </a></li>
             <li><a href="#"> DevOps Engineer Bootcamp </a></li>
             <li><a href="#"> Bootcamp </a></li>
             <li><a href="#"> Data Science Bootcamp </a></li>
             <li><a href="#"> Advanced Full Stack Development </a></li>
             <li><a href="#"> Data Science & Analytics Bootcamp </a></li>
             <li><a href="#"> Cloud Computing </a></li>
             <li><a href="#"> UI/UX Design </a></li>
             <li><a href="#"> AI & Machine Learning Bootcamp: Master the Future </a></li>
           </ul>
         </div>
         <div class="col-lg-3">
           <h4 class="footer-title">
             Bootcamps
           </h4>
           <ul>
             <li><a href="#">Data Science & Analytics Bootcamp </a></li>
             <li><a href="#">Full Stack Software Development Bootcamp </a></li>
             <li><a href="#">UI/UX Design Bootcamp </a></li>
             <li><a href="#">Cloud Computing </a></li>
             <li><a href="#">Sales Excellence Bootcamp </a></li>
             <li><a href="#">Advanced Full Stack Development </a></li>
             <li><a href="#">DevOps Engineer Bootcamp </a></li>
             <li><a href="#">Generative AI & Machine Learning Bootcamp: Master the Future of Technology </a></li>
             <li><a href="#">Data Engineer Bootcamp </a></li>
             <li><a href="#">Data Analytics </a></li>
             <li><a href="#">AI Engineer Bootcamp </a></li>
             <li><a href="#">Front-End Development Bootcamp </a></li>
             <li><a href="#">Back-End Development Bootcamp </a></li>
           </ul>
         </div>
         <div class="col-lg-3">
           <h4 class="footer-title">
             Study Abroad
           </h4>
           <ul>
             <li><a href="#">Master of Business Administration (90 ECTS) </a></li>
             <li><a href="#">Master of Business Administration (60 ECTS) </a></li>
             <li><a href="#">Computer Science </a></li>
             <li><a href="#">MS in Data Analytics </a></li>
             <li><a href="#">Project Management </a></li>
             <li><a href="#">Information Technology </a></li>
             <li><a href="#">International Management </a></li>
             <li><a href="#">Bachelor of Business Administration (180 ECTS) </a></li>
             <li><a href="#">B.Sc. Computer Science (180 ECTS) </a></li>
             <li><a href="#">Masters Degree in Data Analytics and Visualization </a></li>
             <li><a href="#">Masters Degree in Artificial Intelligence </a></li>
             <li><a href="#">MBS in Entrepreneurship and Marketing </a></li>
             <li><a href="#">MSc in Data Analytics </a></li>
             <li><a href="#">MBA - Information Technology Concentration </a></li>
             <li><a href="#">MS in Data Analytics </a></li>
             <li><a href="#">Master of Science in Accountancy </a></li>
             <li><a href="#">MS in Computer Science </a></li>
             <li><a href="#">Master of Science in Business Analytics </a></li>
             <li><a href="#">MS in Data Science </a></li>
             <li><a href="#">MS in Information Technology </a></li>
             <li><a href="#">Master of Business Administration </a></li>
             <li><a href="#">MS in Applied Data Science </a></li>
             <li><a href="#">Master of Business Administration </a></li>
             <li><a href="#">MS in Data Analytics </a></li>
             <li><a href="#">M.Sc. Data Science (60 ECTS) </a></li>
             <li><a href="#">Master of Business Administration </a></li>
             <li><a href="#">MS in Information Technology and Administrative Management </a></li>
             <li><a href="#">MS in Computer Science </a></li>
             <li><a href="#">Master of Business Administration </a></li>
             <li><a href="#">MBA General Management-90 ECTS </a></li>
             <li><a href="#">MSc International Business Management </a></li>
             <li><a href="#">MBA Business Technologies </a></li>
             <li><a href="#">MBA Leading Business Transformation </a></li>
             <li><a href="#">Master of Business Administration </a></li>
             <li><a href="#">MSc Business Intelligence and Data Science </a></li>
             <li><a href="#">MS Data Analytics </a></li>
             <li><a href="#">MS in Management Information Systems </a></li>
             <li><a href="#">MSc International Business and Management </a></li>
             <li><a href="#">MS Engineering Management </a></li>
             <li><a href="#">MS in Machine Learning Engineering </a></li>
             <li><a href="#">MS in Engineering Management </a></li>
             <li><a href="#">MSc Data Engineering </a></li>
             <li><a href="#">MSc Artificial Intelligence Engineering </a></li>
             <li><a href="#">MPS in Informatics </a></li>
             <li><a href="#">MPS in Applied Machine Intelligence </a></li>
             <li><a href="#">MS in Project Management </a></li>
             <li><a href="#">MPS in Analytics </a></li>
             <li><a href="#">MBA International Business Management </a></li>
             <li><a href="#">MS in Project Management </a></li>
             <li><a href="#">MS in Organizational Leadership </a></li>
             <li><a href="#">MPS in Analytics - NEU Canada </a></li>
             <li><a href="#">MBA with specialization </a></li>
             <li><a href="#">MPS in Informatics - NEU Canada </a></li>
             <li><a href="#">Master in Business Administration </a></li>
             <li><a href="#">MS in Digital Marketing and Media </a></li>
             <li><a href="#">MS in Project Management </a></li>
             <li><a href="#">Master in Logistics and Supply Chain Management </a></li>
             <li><a href="#">MSc Sustainable Tourism and Event Management </a></li>
             <li><a href="#">MSc in Circular Economy and Sustainable Innovation </a></li>
             <li><a href="#">MSc in Impact Finance and Fintech Management </a></li>
             <li><a href="#">MS Computer Science </a></li>
             <li><a href="#">MS in Applied Statistics </a></li>
             <li><a href="#">MS in Computer Information Systems </a></li>
           </ul>
         </div>
         <div class="col-lg-3">
           <h4 class="footer-title">
             For College Students
           </h4>
           <ul>
             <li><a href="#">Digital Marketing </a></li>
             <li><a href="#">Business Analytics & Consulting with PwC India </a></li>
             <li><a href="#">Financial Modelling & Analysis with PwC India </a></li>
             <li><a href="#">Data Science & Artificial Intelligence </a></li>
           </ul>
         </div>
       </div>
     </div> -->
     <div class="footerMenu">
       <div class="row">
         <div class="col-lg-3">
           <h4 class="footer-title">
             Supply Chain Management
           </h4>
           <ul>
             <li><a href="#"> Integrated Supply Chain Management </a></li>

           </ul>
         </div>
         <div class="col-lg-3">
           <h4 class="footer-title">
             Archived Programs
           </h4>
           <ul>
             <li><a href="#"> iUniversity's Job-Linked Advanced General Program </a></li>
             <li><a href="#"> Full Stack AI and ML - 100% on-campus </a></li>
             <li><a href="#"> Generative AI for Tech Professionals </a></li>
             <li><a href="#"> Generative AI for Law Professionals </a></li>
             <li><a href="#"> Doctor of Juridical Science (SJD) </a></li>
             <li><a href="#"> Computer Science </a></li>
             <li><a href="#"> Software Development - Spl. in Full Stack Development </a></li>
             <li><a href="#"> Professional Certificate Program In General Management </a></li>
             <li><a href="#"> Professional Certificate Program In Marketing And Sales Management </a></li>
             <li><a href="#"> International Business and Finance Law </a></li>
             <li><a href="#"> CMO Program - ACP in Marketing Leadership Development </a></li>
             <li><a href="#"> Leadership and Management in New Age Businesses </a></li>
           </ul>
         </div>

       </div>
     </div>
     <div class="copyright">
       <p>© {{ $disclaimer->copyright ?? "2015-2028 iUniversity Education Private Limited. All rights reserved" }} <a href="https://wa.link/497emt"
           target="blank">❤️</a></p>
     </div>
   </div>
 </footer>