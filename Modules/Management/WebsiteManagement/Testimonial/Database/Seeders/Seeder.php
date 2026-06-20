<?php
namespace Modules\Management\WebsiteManagement\Testimonial\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class="Modules\Management\WebsiteManagement\Testimonial\Database\Seeders\Seeder"
     */
    static $model = \Modules\Management\WebsiteManagement\Testimonial\Database\Models\Model::class;

    public function run(): void
    {
        self::$model::truncate();

        $testimonials = [
            [
                'client_name'    => 'Rafiqul Islam',
                'client_company' => 'Islam Traders Ltd.',
                'media_type'     => 'image',
                'client_photo'   => null,
                'video_url'      => null,
                'product_id'     => null,
                'rating'         => 5,
                'message'        => '<p>PriyoSoft Corner delivered our e-commerce website on time and within budget. The team was professional, responsive, and genuinely cared about the quality of the work. Our online sales increased by 40% within the first two months. Highly recommended!</p>',
                'is_featured'    => 1,
                'is_visible'     => 1,
                'status'         => 'active',
            ],
            [
                'client_name'    => 'Nusrat Jahan',
                'client_company' => 'Nusrat Fashion House',
                'media_type'     => 'image',
                'client_photo'   => null,
                'video_url'      => null,
                'product_id'     => null,
                'rating'         => 5,
                'message'        => '<p>I needed a custom inventory management system for my fashion business and PriyoSoft built exactly what I envisioned. The UI is clean, everything works flawlessly, and the after-delivery support has been excellent. I couldnt be happier!</p>',
                'is_featured'    => 1,
                'is_visible'     => 1,
                'status'         => 'active',
            ],
            [
                'client_name'    => 'Tanvir Ahmed',
                'client_company' => 'TechBridge Solutions',
                'media_type'     => 'image',
                'client_photo'   => null,
                'video_url'      => null,
                'product_id'     => null,
                'rating'         => 5,
                'message'        => '<p>We hired PriyoSoft Corner to rebuild our company website and integrate a CRM system. The result exceeded our expectations. The team understood our requirements quickly and delivered a polished product. Our client acquisition rate has improved significantly since launch.</p>',
                'is_featured'    => 1,
                'is_visible'     => 1,
                'status'         => 'active',
            ],
            [
                'client_name'    => 'Sadia Sultana',
                'client_company' => 'MediCare Clinic',
                'media_type'     => 'image',
                'client_photo'   => null,
                'video_url'      => null,
                'product_id'     => null,
                'rating'         => 5,
                'message'        => '<p>PriyoSoft developed a patient management portal for our clinic and it transformed our operations. Appointment scheduling, billing, and records are now all in one place. The team was patient, thorough, and incredibly helpful throughout the whole process.</p>',
                'is_featured'    => 1,
                'is_visible'     => 1,
                'status'         => 'active',
            ],
            [
                'client_name'    => 'Mahbubur Rahman',
                'client_company' => 'Rahman Real Estate',
                'media_type'     => 'image',
                'client_photo'   => null,
                'video_url'      => null,
                'product_id'     => null,
                'rating'         => 4,
                'message'        => '<p>Excellent experience working with PriyoSoft Corner. They built a property listing website for us that looks modern and loads very fast. The SEO optimization they provided has already brought us organic leads. Ill definitely work with them again for our next project.</p>',
                'is_featured'    => 1,
                'is_visible'     => 1,
                'status'         => 'active',
            ],
            [
                'client_name'    => 'Farida Begum',
                'client_company' => 'Farida\'s Kitchen (Food Business)',
                'media_type'     => 'image',
                'client_photo'   => null,
                'video_url'      => null,
                'product_id'     => null,
                'rating'         => 5,
                'message'        => '<p>I had no idea how to take my home kitchen business online. PriyoSoft Corner guided me from start to finish — domain, hosting, website, and even social media setup. They made everything simple. Now I receive online orders every single day!</p>',
                'is_featured'    => 1,
                'is_visible'     => 1,
                'status'         => 'active',
            ],
            [
                'client_name'    => 'Imran Hossain',
                'client_company' => 'Hossain Group of Industries',
                'media_type'     => 'image',
                'client_photo'   => null,
                'video_url'      => null,
                'product_id'     => null,
                'rating'         => 5,
                'message'        => '<p>We engaged PriyoSoft Corner for a large ERP system covering HR, payroll, inventory, and finance. The team handled the complexity with professionalism. They delivered a robust, scalable system that our team adopted quickly. The ROI has been remarkable.</p>',
                'is_featured'    => 0,
                'is_visible'     => 1,
                'status'         => 'active',
            ],
            [
                'client_name'    => 'Sharmin Akter',
                'client_company' => 'Sharmin Academy (Online Education)',
                'media_type'     => 'image',
                'client_photo'   => null,
                'video_url'      => null,
                'product_id'     => null,
                'rating'         => 5,
                'message'        => '<p>PriyoSoft Corner built a complete Learning Management System for my online academy. Video courses, quizzes, certificates, and student dashboards — everything works perfectly. Student enrollment has tripled since we launched. Absolutely worth every taka!</p>',
                'is_featured'    => 0,
                'is_visible'     => 1,
                'status'         => 'active',
            ],
            [
                'client_name'    => 'Kamal Uddin',
                'client_company' => 'Kamal Logistics',
                'media_type'     => 'image',
                'client_photo'   => null,
                'video_url'      => null,
                'product_id'     => null,
                'rating'         => 4,
                'message'        => '<p>The delivery tracking system PriyoSoft Corner built for us is fantastic. Drivers update status from their phones and customers receive live updates. Our complaint rate dropped by 60%. The team was collaborative and delivered ahead of schedule.</p>',
                'is_featured'    => 0,
                'is_visible'     => 1,
                'status'         => 'active',
            ],
            [
                'client_name'    => 'Parveen Chowdhury',
                'client_company' => 'Chowdhury Law Associates',
                'media_type'     => 'image',
                'client_photo'   => null,
                'video_url'      => null,
                'product_id'     => null,
                'rating'         => 5,
                'message'        => '<p>Our law firm needed a professional website with a case management portal. PriyoSoft Corner nailed the brief. The site looks authoritative, and the portal keeps our case records perfectly organised. Client inquiries through the website have increased threefold.</p>',
                'is_featured'    => 0,
                'is_visible'     => 1,
                'status'         => 'active',
            ],
            [
                'client_name'    => 'Arif Billah',
                'client_company' => 'ArifTech Startup',
                'media_type'     => 'image',
                'client_photo'   => null,
                'video_url'      => null,
                'product_id'     => null,
                'rating'         => 5,
                'message'        => '<p>As a startup founder, I needed a reliable tech partner who could move fast. PriyoSoft Corner launched our MVP in just six weeks. The code quality is clean, the app performs great, and the team has been a true partner in our growth journey. Highly recommended for startups!</p>',
                'is_featured'    => 0,
                'is_visible'     => 1,
                'status'         => 'active',
            ],
            [
                'client_name'    => 'Rohima Khatun',
                'client_company' => 'Rohima Boutique',
                'media_type'     => 'image',
                'client_photo'   => null,
                'video_url'      => null,
                'product_id'     => null,
                'rating'         => 4,
                'message'        => '<p>My boutique now has a beautiful online store thanks to PriyoSoft Corner. The checkout process is smooth, mobile-friendly, and customers love shopping on it. The team also helped with Facebook pixel and Google Analytics setup. Great value for money!</p>',
                'is_featured'    => 0,
                'is_visible'     => 1,
                'status'         => 'active',
            ],
        ];

        foreach ($testimonials as $testimonial) {
            self::$model::create($testimonial);
        }
    }
}
