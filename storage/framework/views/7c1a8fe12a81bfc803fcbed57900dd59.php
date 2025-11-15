<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Miniver&display=swap');
    </style>
    <title>Shopo</title>
    <!-- Linking font awsome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <!-- Link Swiper css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css">
    <link rel="stylesheet" href=<?php echo e(asset('front-assets/css/style.css')); ?>>
</head>
<body>
    <!-- Header / Navbar -->
    <header>
        <nav class="navbar section-content">
            <a href="#" class="nav-logo">
                <h2 class="logo-text">Shopo</h2>
                <ul class="nav-menu">
                    <button id="menu-close-button" class="fas fa-times"></button>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            الرئيسية
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#about" class="nav-link">
                            من نحن؟
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#menu" class="nav-link">
                            عملائنا
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#testimonials" class="nav-link">
                            توصيات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#faq" class="nav-link">
                            الأسئلة الشائعة
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" class="nav-link">
                            اتصل بنا
                        </a>
                    </li>
                </ul>

                <button id="menu-open-button" class="fas fa-bars"></button>
            </a>
        </nav>
    </header>

    <main>
        <!-- Hero section -->
         <section class="hero-section">
            <div class="section-content">
                <div class="hero-details">
                    <h2 class="title">مختلف أنواع المتاجر</h2>
                    <h3 class="subtitle">إكتشف المحلات المتواجدة بالقرب منك!</h3>
                    <p class="description">جرب تطبيقنا</p>
                    <div class="buttons">
                        <a href="#" class="button order-now">حمل الان</a>
                        <a href="#contact" class="button contact-us">اتصل بنا</a>
                    </div>
                </div>
                <div class="hero-image-wrapper">
                    <img src=<?php echo e(asset('front-assets/img/shopo.png')); ?> alt="Hero" class="hero-image">
                </div>
            </div>
         </section>

         <!-- about section -->
          <section class="about-section" id="about">
            <div class="section-content">
                <div class="about-image-wrapper">
                    <img src=<?php echo e(asset('front-assets/img/shopo.jpg')); ?> alt="About" class="about-image">
                </div>
                <div class="about-details">
                    <h2 class="section-title">من نحن؟</h2>
                    <p class="text"> <?php echo $about; ?> </p>
                    <div class="social-link-list">
                        <a href="https://www.facebook.com/profile.php?id=61583358366597" class="social-link" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.facebook.com/profile.php?id=61583358366597" class="social-link" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://www.tiktok.com/@naar.baraao?_r=1&_t=ZS-91CNpuqi9ic" class="social-link" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="https://www.tiktok.com/@naar.baraao?_r=1&_t=ZS-91CNpuqi9ic" class="social-link" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
          </section>

          <!-- Menu section -->
           <section class="menu-section" id="menu">
            <h2 class="section-title">عملائنا</h2>
            <div class="section-content">
                <ul class="menu-list">
                    <li class="menu-item">
                        <img src=<?php echo e(asset('front-assets/img/1.png')); ?> alt="hot" class="menu-image">
                        <h3 class="name">hicham pizza</h3>
                        <p class="text">wide range of stiming hot coffee</p>
                    </li>
                    <li class="menu-item">
                        <img src=<?php echo e(asset('front-assets/img/3.png')); ?> alt="cold-beverages.png" class="menu-image">
                        <h3 class="name">hicham grill</h3>
                        <p class="text">wide range of stiming hot coffee</p>
                    </li>
                    <li class="menu-item">
                        <img src=<?php echo e(asset('front-assets/img/2.jpeg')); ?> alt="refreshment.png" class="menu-image">
                        <h3 class="name">el padre</h3>
                        <p class="text">wide range of stiming hot coffee</p>
                    </li>
                    <li class="menu-item">
                        <img src=<?php echo e(asset('front-assets/img/4.png')); ?> alt="special-combo.png" class="menu-image">
                        <h3 class="name">condor</h3>
                        <p class="text">wide range of stiming hot coffee</p>
                    </li>
                    <li class="menu-item">
                        <img src=<?php echo e(asset('front-assets/img/5.png')); ?> alt="burger-frenchfries.png" class="menu-image">
                        <h3 class="name">iris</h3>
                        <p class="text">wide range of stiming hot coffee</p>
                    </li>
                    <li class="menu-item">
                        <img src=<?php echo e(asset('front-assets/img/6.png')); ?> alt="desserts.png" class="menu-image">
                        <h3 class="name">decathlon</h3>
                        <p class="text">wide range of stiming hot coffee</p>
                    </li>
                </ul>
            </div>
           </section>

        <!-- Testimonial section -->
         <section class="testimonials-section" id="testimonials">
            <h2 class="section-title">توصيات</h2>
            <div class="section-content">
                <div class="slider-container swiper">
                    <div class="slider-wrapper">
                        <ul class="testimonials-list swiper-wrapper">
                            <li class="testimonial swiper-slide">
                                <img src=<?php echo e(asset('front-assets/img/f.jpg')); ?> alt="User" class="user-image">
                                <h3 class="name">فوزي زواقري</h3>
                                <i class="feedback">"تطبيق رائع"</i>
                            </li>
                            <li class="testimonial swiper-slide">
                                <img src=<?php echo e(asset('front-assets/img/d.jpg')); ?> alt="User" class="user-image">
                                <h3 class="name">Djaber</h3>
                                <i class="feedback">"coooooooooooooooooooooooool"</i>
                            </li>
                            <li class="testimonial swiper-slide">
                                <img src=<?php echo e(asset('front-assets/img/f.jpg')); ?> alt="User" class="user-image">
                                <h3 class="name">فوزي زواقري</h3>
                                <i class="feedback">"تطبيق رائع"</i>
                            </li>
                            <li class="testimonial swiper-slide">
                                <img src=<?php echo e(asset('front-assets/img/d.jpg')); ?> alt="User" class="user-image">
                                <h3 class="name">Djaber</h3>
                                <i class="feedback">"coooooooooooooooooooooooool"</i>
                            <li class="testimonial swiper-slide">
                                <img src=<?php echo e(asset('front-assets/img/f.jpg')); ?> alt="User" class="user-image">
                                <h3 class="name">فوزي زواقري</h3>
                                <i class="feedback">"تطبيق رائع"</i>
                            </li>
                            </li>
                        </ul>

                         <!-- If we need pagination -->
                        <div class="swiper-pagination"></div>
                        <!-- If we need navigation buttons -->
                        <div class="swiper-slide-button swiper-button-prev"></div>
                        <div class="swiper-slide-button swiper-button-next"></div>
                    </div>
                </div>
            </div>
         </section>

         <!-- Gallery section -->
          <!-- <section class="gallery-section" id="gallery">
            <h2 class="section-title">Gallery</h2>
            <div class="section-content">
                <ul class="gallery-list">
                    <li class="gallery-item">
                        <img src="images/gallery-1.jpg" alt="Gallery" class="gallery-image">
                    </li>
                    <li class="gallery-item">
                        <img src="images/gallery-2.jpg" alt="Gallery" class="gallery-image">
                    </li>
                    <li class="gallery-item">
                        <img src="images/gallery-3.jpg" alt="Gallery" class="gallery-image">
                    </li>
                    <li class="gallery-item">
                        <img src="images/gallery-4.jpg" alt="Gallery" class="gallery-image">
                    </li>
                    <li class="gallery-item">
                        <img src="images/gallery-5.jpg" alt="Gallery" class="gallery-image">
                    </li>
                    <li class="gallery-item">
                        <img src="images/gallery-6.jpg" alt="Gallery" class="gallery-image">
                    </li>
                </ul>
            </div>
          </section> -->
          
          <!-- Faq section -->
            <section class="faq-section" id="faq">
                <h2 class="section-title">الأسئلة الشائعة</h2>
                <div class="section-content">

                    

                    <div id="questions-container" class="flex flex-col items-center gap-12 m-4">
                        <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex flex-col p-4 border-r rounded-lg shadow-slate-200 shadow-lg dark:shadow-mydarkShadow
                                w-full md:w-[80%] lg:w-[50%] transition-all
                                " style="border-right-color: #3b141c;">
                                <div class="flex justify-between items-center cursor-pointer gap-4">
                                    <h3 class="text-sm sm:text-lg"><?php echo e($item['question']); ?></h3>
                                    <span style="color: #3b141c;">
                                        <span chevron-icon="" style="color: #3b141c;">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M240.971 130.524l194.343 194.343c9.373 9.373 9.373 24.569 0 33.941l-22.667 22.667c-9.357 9.357-24.522 9.375-33.901.04L224 227.495 69.255 381.516c-9.379 9.335-24.544 9.317-33.901-.04l-22.667-22.667c-9.373-9.373-9.373-24.569 0-33.941L207.03 130.525c9.372-9.373 24.568-9.373 33.941-.001z"></path>
                                            </svg>
                                        </span>
                                    </span>
                                </div>
                                <p class="pt-8 leading-loose text-secondary dark:text-darksecondary hidden">
                                <?php echo $item['answer']; ?>

                                </p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- <div class="faq-container">
                    <div class="faq-item">
                        <button class="faq-question">
                        What is your return policy?
                        <span class="faq-icon">+</span>
                        </button>
                        <div class="faq-answer">
                        <p>We offer a 30-day return policy for unused and unopened items. Please contact support for help with returns.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                        How long does shipping take?
                        <span class="faq-icon">+</span>
                        </button>
                        <div class="faq-answer">
                        <p>Shipping usually takes 3–7 business days, depending on your location and shipping method selected.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                        Do you offer international delivery?
                        <span class="faq-icon">+</span>
                        </button>
                        <div class="faq-answer">
                        <p>Yes, we ship worldwide. International shipping rates and delivery times vary by destination.</p>
                        </div>
                    </div>
                    </div> -->
                </div>
            </section>

          <!-- Contact section -->
           <section class="contact-section" id="contact">
            <h2 class="section-title">اتصل بنا</h2>
            <div class="section-content">
                <ul class="contact-info-list">
                    <?php echo html_entity_decode(str_replace('<br>', '', $contact)); ?>

                </ul>

                <form action="#" class="contact-form">
                    <input type="text" placeholder="Your name" class="form-input" required>
                    <input type="email" placeholder="Your email" class="form-input" required>
                    <textarea name="" id="" placeholder="Your message" class="form-input" required></textarea>
                    <button class="submit-button">Submit</button>
                </form>
            </div>
           </section>

           <!-- Footer section -->
            <footer class="footer-section">
                <div class="section-content">
                    <div class="social-link-list">
                        <a href="https://www.facebook.com/profile.php?id=61583358366597" class="social-link" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.tiktok.com/@naar.baraao?_r=1&_t=ZS-91CNpuqi9icttps://www.facebook.com/profile.php?id=61583358366597" class="social-link" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://www.tiktok.com/@naar.baraao?_r=1&_t=ZS-91CNpuqi9icttps://www.tiktok.com/@naar.baraao?_r=1&_t=ZS-91CNpuqi9ic" class="social-link" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="https://www.tiktok.com/@naar.baraao?_r=1&_t=ZS-91CNpuqi9ic" class="social-link" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-tiktok"></i></a>
                    </div>
                    <p class="copyright-text">Shopo جميع الحقوق محفوطة © <?php echo e(date('Y')); ?></p>

                </div>
            </footer>
    </main>
            

            <script>
            document.querySelectorAll('.faq-item').forEach(item => {
                item.addEventListener('click', () => {
                    const answer = item.querySelector('.answer');
                    answer.classList.toggle('hidden');
                    const icon = item.querySelector('svg');
                    icon.classList.toggle('rotate-180');
                });
            });
            </script>

    <!-- Link Swiper script -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    
    <!-- Link coustom js script -->
    <script src=<?php echo e(asset('front-assets/js/script.js')); ?>></script>
</body>
</html>
<?php /**PATH C:\Users\A\Desktop\Shopo\Shopo\Shopo_api\resources\views/welcome.blade.php ENDPATH**/ ?>