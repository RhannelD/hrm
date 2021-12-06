<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            [
                'department' => 'Production Department',
                'description' => 'The production department is responsible for converting raw materials and other inputs into finished goods or services.',
            ],
            [
                'department' => 'Finance and Accounting Department',
                'description' => 'The finance and accounting department is responsible for transporting this revenue in different activities to ensure maximum growth of the wealth.',
            ],
            [
                'department' => 'Operation Department',
                'description' => 'Involves managing the operations and processes of an organization. Some of the functions performed by an operations manager include supply chain management, product design, forecasting, quality control, and delivery management.',
            ],
            [
                'department' => 'Research and Development Department',
                'description' => 'The role of an R&D department is to keep a business competitive by providing insights into the market and developing new services / products or improving existing ones accordingly.',
            ],
            [
                'department' => 'Marketing Department',
                'description' => 'The marketing department takes responsibility for generating revenue.',
            ],
            [
                'department' => 'Information Department',
                'description' => 'Oversees the installation and maintenance of computer network systems within a company.',
            ],
            [
                'department' => 'Purchasing Department',
                'description' => 'Establishes the company’s purchasing policies and procedures.',
            ],
        ];

        foreach ($departments as $department) {
            Department::factory()->create([
                'department' => $department['department'],
                'description' => $department['description'],
            ]);
        }
    }
}
