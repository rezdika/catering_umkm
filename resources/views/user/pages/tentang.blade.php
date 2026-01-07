@extends('user.main')

@section('title', 'Tentang Kami - CateringKu')

@php
$breadcrumbs = [
    ['title' => 'Tentang Kami', 'url' => route('tentang')]
];
@endphp

@section('content')
<!-- Hero Section -->
<section class="relative h-screen flex items-center justify-center text-white overflow-hidden" style="background-image: url('{{ asset('assets/img/hero/tentang.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <h1 class="text-6xl font-bold mb-4 font-playfair">TENTANG KAMI</h1>
            <p class="text-xl mb-6 font-poppins">Cerita di balik cita rasa yang menggugah selera</p>
            
            <nav class="flex justify-center items-center space-x-2 text-white opacity-90">
                <a href="{{ route('beranda') }}" class="hover:text-brand-cream transition duration-300">Home</a>
                <span>></span>
                <span class="text-brand-cream">Tentang Kami</span>
            </nav>
        </div>
    </div>
</section>

@include('user.partials.breadcrumb')

<!-- About Intro Section -->
<section class="py-16 bg-brand-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-left">
            <h2 class="text-4xl font-bold text-brand-red mb-8">NIKMATI MASAKAN RUMAH SETIAP HARI</h2>
            
            <div class="max-w-4xl space-y-6">
                <p class="text-lg text-brand-black opacity-90">
                    Tahukah kamu bahwa banyak orang melewatkan makanan bergizi karena keterbatasan waktu dan kesibukan sehari-hari?
                </p>
                <p class="text-lg text-brand-black opacity-90">
                    Di CateringKu, kami percaya ada cara yang lebih baik.
                </p>
                <p class="text-lg text-brand-black opacity-90">
                    Kami menghadirkan masakan rumahan yang dimasak setiap hari menggunakan bahan-bahan segar pilihan, sehingga kamu bisa menikmati hidangan lezat, sehat, dan menenangkan seperti di rumah sendiri.
                </p>
                <p class="text-lg text-brand-black opacity-90">
                    Ucapkan selamat tinggal pada makanan instan yang terburu-buru, dan nikmati hidangan rumahan berkualitas dengan pelayanan yang siap diandalkan bersama CateringKu.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Meet Your New Best Friend Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div>
                <h2 class="text-4xl font-bold text-brand-red mb-8">TEMUI SAHABAT MAKAN BARU ANDA</h2>
                
                <div class="space-y-6">
                    <p class="text-lg text-brand-black opacity-90">
                        Memperkenalkan CateringKu, layanan catering rumahan dengan kualitas yang tak perlu diragukan.
                    </p>
                    <p class="text-lg text-brand-black opacity-90">
                        Dimasak dari bahan-bahan segar pilihan dan diolah setiap hari, hidangan kami menghadirkan rasa rumahan yang hangat dan lezat untuk menemani aktivitas Anda.
                    </p>
                    <p class="text-lg text-brand-black opacity-90">
                        Menu kami lebih sehat, bergizi, dan seimbang, sehingga cocok untuk konsumsi harian, keluarga, maupun kebutuhan kantor.
                    </p>
                    <p class="text-lg text-brand-black opacity-90">
                        Dengan pengiriman cepat dan pelayanan ramah, Anda bisa menikmati makanan enak tanpa repot.
                    </p>
                    <p class="text-lg text-brand-black opacity-90">
                        Lebih praktis, lebih nikmat, dan lebih menenangkan — apa lagi yang tidak disukai?
                    </p>
                </div>
            </div>
            
            <!-- Right Content - Menu Slider -->
            <div class="relative">
                <div class="menu-slider-container overflow-hidden rounded-lg">
                    <div class="menu-slider-track flex transition-transform duration-500 ease-in-out" id="menuSlider">
                        <div class="menu-slider-item w-full flex-shrink-0">
                            <div class="text-center">
                                <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                     alt="Nasi Gudeg Spesial" class="w-full h-80 object-cover rounded-lg mb-4">
                                <h3 class="text-xl font-bold text-brand-black mb-2">Nasi Gudeg Spesial</h3>
                                <p class="text-brand-black opacity-80">Nasi gudeg dengan bumbu rahasia yang istimewa dan cita rasa autentik</p>
                            </div>
                        </div>
                        <div class="menu-slider-item w-full flex-shrink-0">
                            <div class="text-center">
                                <img src="https://images.unsplash.com/photo-1603133872878-684f208fb84b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                     alt="Ayam Bakar Madu" class="w-full h-80 object-cover rounded-lg mb-4">
                                <h3 class="text-xl font-bold text-brand-black mb-2">Ayam Bakar Madu</h3>
                                <p class="text-brand-black opacity-80">Ayam bakar dengan bumbu madu yang manis dan gurih, disajikan hangat</p>
                            </div>
                        </div>
                        <div class="menu-slider-item w-full flex-shrink-0">
                            <div class="text-center">
                                <img src="https://images.unsplash.com/photo-1528735602780-2552fd46c7af?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                     alt="Soto Ayam Lamongan" class="w-full h-80 object-cover rounded-lg mb-4">
                                <h3 class="text-xl font-bold text-brand-black mb-2">Soto Ayam Lamongan</h3>
                                <p class="text-brand-black opacity-80">Soto ayam khas Lamongan dengan kuah bening yang segar dan daging ayam empuk</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Slider Dots -->
                <div class="flex justify-center mt-6 space-x-2">
                    <button class="w-3 h-3 bg-brand-red rounded-full transition duration-300 menu-dot active" onclick="currentMenuSlide(1)"></button>
                    <button class="w-3 h-3 bg-gray-300 rounded-full transition duration-300 menu-dot" onclick="currentMenuSlide(2)"></button>
                    <button class="w-3 h-3 bg-gray-300 rounded-full transition duration-300 menu-dot" onclick="currentMenuSlide(3)"></button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why We Started Section -->
<section class="py-16 bg-brand-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-left">
            <h2 class="text-4xl font-bold text-brand-red mb-8">KENAPA KAMI MEMULAI</h2>
            
            <div class="max-w-4xl space-y-6">
                <p class="text-lg text-brand-black opacity-90">
                    Di CateringKu, kami percaya bahwa makanan bukan sekadar pengisi perut, tetapi bagian penting dari kualitas hidup sehari-hari.
                </p>
                <p class="text-lg text-brand-black opacity-90">
                    Di tengah kesibukan, banyak orang terpaksa mengandalkan makanan instan yang kurang bergizi dan minim rasa rumahan. Kami melihat ini sebagai masalah yang tidak bisa diabaikan.
                </p>
                <p class="text-lg text-brand-black opacity-90">
                    CateringKu didirikan dengan tujuan menghadirkan masakan rumahan yang lezat, bergizi, dan dibuat dari bahan segar pilihan, tanpa harus mengorbankan waktu dan kenyamanan Anda.
                </p>
                <p class="text-lg text-brand-black opacity-90">
                    Berbekal pengalaman, komitmen pada kualitas, dan kecintaan pada masakan rumahan, kami menghadirkan layanan catering yang praktis namun tetap mengutamakan rasa dan kebersihan.
                </p>
                <p class="text-lg text-brand-black opacity-90">
                    Dengan menyediakan pilihan yang lebih baik, kami berharap bisa membantu lebih banyak orang menikmati makanan rumahan yang sehat, hangat, dan dapat diandalkan setiap hari.
                </p>
                <p class="text-lg text-brand-black opacity-90">
                    Bergabunglah bersama kami, dan rasakan bagaimana makanan sederhana bisa membawa kenyamanan dan kualitas dalam setiap hari Anda.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-brand-red text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold mb-2">5000+</div>
                <div class="text-brand-light">Pelanggan Puas</div>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">50+</div>
                <div class="text-brand-light">Menu Pilihan</div>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">4+</div>
                <div class="text-brand-light">Tahun Pengalaman</div>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">100%</div>
                <div class="text-brand-light">Halal & Higienis</div>
            </div>
        </div>
    </div>
</section>



<!-- Team Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-brand-black mb-4">Tim Kami</h2>
            <p class="text-brand-black opacity-80">Orang-orang hebat di balik kelezatan setiap hidangan</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 justify-center">
            <div class="text-center">
                <img src="{{ asset('assets/img/tim/tim1.png') }}" 
                     alt="Rezdika Akbar Dwi Putra Hadi" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                <h3 class="text-xl font-semibold mb-2 text-brand-black">Rezdika Akbar Dwi Putra Hadi</h3>
                <p class="text-brand-red font-medium mb-2">Founder & Head Chef</p>
                <p class="text-brand-black opacity-80 text-sm">Pendiri D'Yummy Catering dengan passion dalam menciptakan masakan rumahan berkualitas</p>
            </div>
            
            <div class="text-center">
                <img src="{{ asset('assets/img/tim/tim2.png') }}" 
                     alt="Immanuel Tua Lumban Gaol" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                <h3 class="text-xl font-semibold mb-2 text-brand-black">Immanuel Tua Lumban Gaol</h3>
                <p class="text-brand-red font-medium mb-2">Co-Founder & Operations Manager</p>
                <p class="text-brand-black opacity-80 text-sm">Memastikan setiap pesanan diproses dengan sempurna dan pelayanan terbaik</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <!-- FAQ List -->
            <div>
                <h2 class="text-3xl font-bold text-brand-black mb-8">Frequently Ask Question</h2>

                <div class="space-y-4">
                    <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200">
                        <button
                            class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition duration-300">
                            <span class="text-brand-black font-medium">Apa itu D'Yummy Catering?</span>
                            <div class="w-6 h-6 bg-brand-red rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold faq-icon">+</span>
                            </div>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-600">D'Yummy Catering adalah layanan catering yang menyediakan makanan
                                berkualitas tinggi untuk berbagai acara, mulai dari acara kantor, pernikahan, hingga
                                acara keluarga dengan cita rasa autentik Indonesia.</p>
                        </div>
                    </div>

                    <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200">
                        <button
                            class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition duration-300">
                            <span class="text-brand-black font-medium">Mengapa harus memilih D'Yummy Catering?</span>
                            <div class="w-6 h-6 bg-brand-red rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold faq-icon">+</span>
                            </div>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-600">Kami menggunakan bahan-bahan segar berkualitas tinggi, memiliki
                                koki berpengalaman, pengiriman cepat dalam 30 menit, dan harga yang terjangkau dengan
                                pelayanan terbaik 24/7.</p>
                        </div>
                    </div>

                    <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200">
                        <button
                            class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition duration-300">
                            <span class="text-brand-black font-medium">Bagaimana cara menghubungi kami?</span>
                            <div class="w-6 h-6 bg-brand-red rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold faq-icon">+</span>
                            </div>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-600">Anda dapat menghubungi kami melalui telepon di +62 821-2609-9407,
                                email ke rezdika31@gmail.com, atau mengisi form kontak di website ini. Kami siap
                                melayani Anda 24/7.</p>
                        </div>
                    </div>

                    <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200">
                        <button
                            class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition duration-300">
                            <span class="text-brand-black font-medium">Berapa minimum order untuk catering?</span>
                            <div class="w-6 h-6 bg-brand-red rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold faq-icon">+</span>
                            </div>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-600">Minimum order untuk layanan catering adalah 10 porsi. Untuk paket
                                khusus acara besar, silakan hubungi kami untuk mendapatkan penawaran terbaik.</p>
                        </div>
                    </div>

                    <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200">
                        <button
                            class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition duration-300">
                            <span class="text-brand-black font-medium">Apakah ada promo atau diskon?</span>
                            <div class="w-6 h-6 bg-brand-red rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold faq-icon">+</span>
                            </div>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-600">Ya! Kami memiliki promo harian dan paket gratis untuk pembelian di
                                atas Rp 100.000. Ikuti media sosial kami untuk mendapatkan update promo terbaru.</p>
                        </div>
                    </div>

                    <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200">
                        <button
                            class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition duration-300">
                            <span class="text-brand-black font-medium">Bagaimana sistem pembayaran?</span>
                            <div class="w-6 h-6 bg-brand-red rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold faq-icon">+</span>
                            </div>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-600">Kami menerima pembayaran tunai, transfer bank, e-wallet (OVO,
                                GoPay, DANA), dan kartu kredit. Pembayaran dapat dilakukan saat pemesanan atau cash on
                                delivery.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Illustration & CTA -->
            <div class="flex flex-col items-center justify-center space-y-8">
                <!-- Illustration -->
                <div class="text-center">
                    <img src="{{ asset('assets/img/ilustration2.png') }}" alt="FAQ Illustration"
                        class="w-full max-w-md mx-auto">
                </div>

              
            </div>

        </div>
    </div>
</section>

  <!-- CTA Section -->
    <section class="mb-10  mt-2" style="background-image: url('{{ asset('assets/img/bg-ctaa2.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 250px">
        <div class="text-center">
            <h3 class="text-2xl font-bold text-brand-black mb-4">Masih Ada Pertanyaan?</h3>
            <p class="text-gray-600 mb-6">Jika pertanyaan Anda belum terjawab, silakan hubungi kami melalui form kontak</p>
            <button onclick="scrollToContactForm()"
                class="bg-brand-red text-white py-3 px-8 rounded-lg font-semibold hover:bg-brand-black transition duration-300 shadow-lg">
                Hubungi Kami
            </button>
        </div>
    </section>
               


@push('styles')
<style>
.font-playfair {
    font-family: 'Playfair Display', serif;
}

.font-poppins {
    font-family: 'Poppins', sans-serif;
}

.menu-dot.active {
    background-color: #8E1616;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentMenuSlideIndex = 0;
    const menuSlides = document.querySelectorAll('#menuSlider .menu-slider-item');
    const menuDots = document.querySelectorAll('.menu-dot');
    const menuSlider = document.getElementById('menuSlider');

    function showMenuSlide(index) {
        if (menuSlider) {
            menuSlider.style.transform = `translateX(-${index * 100}%)`;
            
            menuDots.forEach((dot, i) => {
                if (i === index) {
                    dot.classList.add('active');
                    dot.classList.remove('bg-gray-300');
                    dot.classList.add('bg-brand-red');
                } else {
                    dot.classList.remove('active');
                    dot.classList.add('bg-gray-300');
                    dot.classList.remove('bg-brand-red');
                }
            });
        }
    }

    window.currentMenuSlide = function(slideNumber) {
        currentMenuSlideIndex = slideNumber - 1;
        showMenuSlide(currentMenuSlideIndex);
    }

    function nextMenuSlide() {
        currentMenuSlideIndex = (currentMenuSlideIndex + 1) % menuSlides.length;
        showMenuSlide(currentMenuSlideIndex);
    }

    // Initialize first slide
    showMenuSlide(0);
    
    // Auto slide every 4 seconds
    setInterval(nextMenuSlide, 4000);

    // FAQ Toggle functionality
    const faqToggles = document.querySelectorAll('.faq-toggle');
    
    faqToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const faqItem = this.closest('.faq-item');
            const faqContent = faqItem.querySelector('.faq-content');
            const faqIcon = faqItem.querySelector('.faq-icon');
            
            // Close all other FAQ items
            faqToggles.forEach(otherToggle => {
                if (otherToggle !== this) {
                    const otherItem = otherToggle.closest('.faq-item');
                    const otherContent = otherItem.querySelector('.faq-content');
                    const otherIcon = otherItem.querySelector('.faq-icon');
                    
                    otherContent.classList.add('hidden');
                    otherIcon.textContent = '+';
                }
            });
            
            // Toggle current FAQ item
            if (faqContent.classList.contains('hidden')) {
                faqContent.classList.remove('hidden');
                faqIcon.textContent = '-';
            } else {
                faqContent.classList.add('hidden');
                faqIcon.textContent = '+';
            }
        });
    });
});
</script>
@endpush
@endsection