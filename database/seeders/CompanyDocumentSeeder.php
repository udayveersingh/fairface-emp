<?php

namespace Database\Seeders;

use App\Models\CompanyDocument;
use Illuminate\Database\Seeder;

class CompanyDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company_documents = ['Company Registration Certificate', 'VAT Certificate', 'Rental Lease document', 'Insurance Documents', 'Employees Handbook'];

        foreach ($company_documents as $value) {
            $document = CompanyDocument::where('name', '=', $value)->first();
            if (!empty($document)) {
                $com_document = CompanyDocument::find($document->id);
            } else {
                $com_document = new CompanyDocument();
            }

            $com_document->name = $value;
            $com_document->attachment = Null;
            $com_document->save();
        }
    }
}
