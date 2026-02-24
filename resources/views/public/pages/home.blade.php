@extends('public.layouts.app')
@section('content')

   <section class="relative bg-black">
    <img src="{{ asset('public/images/hero.jpg') }}"
         class="absolute inset-0 w-full h-full object-cover opacity-40">
        <div class="relative max-w-7xl mx-auto px-6 py-32 text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Professional Website Development Services
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-gray-200 mb-8">
                We provide clear, simple, and straight-to-the-point solutions to businesses worldwide.
            </p>
            <a href="#contact"
            class="inline-block bg-red-600 hover:bg-red-700 px-8 py-3 rounded-lg font-semibold transition">
                Let us talk
            </a>
        </div>
</section>
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
        <div>
            <img src="{{ asset('public/images/about.jpg') }}"
                 class="rounded-xl shadow-lg">
        </div>
        <div>
            <span class="text-red-600 font-semibold uppercase text-sm">Welcome to the Industry</span>
            <h2 class="text-3xl font-bold mt-2 mb-4">About Us</h2>
            <p class="text-gray-600 leading-relaxed">
            AceWebX is website development company in india. Our team of skilled professionals offers exceptional Software Development, Web Development, Web Design, Mobile App Development and Digital Marketing services - as well as a results-driven approach and strong ethical values - to long-term relationships with our clients. We pride ourselves on time and cost efficiency as we apply only cutting-edge tactics and methods suited specifically for your preferences or goals - AceWebX truly provides everything your business could ever require to thrive and prosper!
            </br>AceWebX boasts an international reach with our technology-savvy team in Mohali (India). AceWebX continues to redefine outsourcing solutions by adopting global standard management and delivery techniques for optimal quality results for our client and trust us over time. Our work speaks for itself!
            </p>
        </div>
    </div>
</section>
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-10">Technology Stack</h2>

        <div class="grid grid-cols-3 md:grid-cols-7 gap-6">
            @foreach (['html','css','js','node','shopify','wordpress','php'] as $tech)
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                    <img src="{{ asset("assets/icons/$tech.svg") }}" class="mx-auto h-10">
                </div>
            @endforeach
        </div>
    </div>
</section>
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">
            We help 200+ clients grow their business
        </h2>

        <div class="grid md:grid-cols-3 gap-8">

            @foreach ([
                ['Testing','Website testing ensures reliability and usability'],
                ['Web Design','Beautiful & responsive website designs'],
                ['UI/UX Design','User-focused digital experiences']
            ] as $service)

            <div class="border rounded-xl p-8 text-center hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-3">{{ $service[0] }}</h3>
                <p class="text-gray-600 mb-6">{{ $service[1] }}</p>
                <a href="#" class="text-red-600 font-semibold hover:underline">
                    Read More →
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
<section class="py-20 bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold mb-10">Industry Insights</h2>

        <div class="grid md:grid-cols-3 gap-8">
            @for ($i = 1; $i <= 3; $i++)
                <div class="bg-gray-800 rounded-lg overflow-hidden">
                    <img src="{{ asset('assets/images/blog'.$i.'.jpg') }}">
                    <div class="p-6">
                        <h3 class="font-semibold mb-2">Technology Trends {{ $i }}</h3>
                        <p class="text-gray-400 text-sm">
                            Exploring the latest innovations shaping the industry.
                        </p>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-8xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-10">What Clients Say</h2>
        <div class="grid md:grid-cols-3 gap-8 slider">
            @for ($i = 1; $i <= 8; $i++)
                <div class="border rounded-xl p-6 shadow-sm">
                    <p class="text-gray-600 mb-4">
                        Excellent service, professional team, and timely delivery.
                    </p>
                    <strong class="block">Client {{ $i }}</strong>
                </div>
            @endfor
        </div>
    </div>
</section>
<section class="bg-[#F5F9FB] py-16 text-black">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
       <div class="max-w-2xl">
        <h2 class="text-3xl font-bold mb-6 md:mb-0">
            Let’s Design Your New Website
        </h2>
        <p>Do you want to have a website that stands out and impresses your clients? Then we are ready to help! Click on the button to contact us and discuss your ideas.</p>
        </div>
        <a href="#contact"
           class="bg-red-600 hover:bg-red-700 px-8 py-3 rounded-lg font-semibold transition text-white">
            Let’s Get Started
        </a>
    </div>
</section>

@endsection