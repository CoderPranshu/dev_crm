<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailedQuotation;
use App\Models\QuotationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;


class DetailedQuotationController extends Controller
{



    // 
    
    /**
     * Show create form.
     */
    public function create()
    {
        $categories = QuotationCategory::with([
            'services' => function ($query) {
                $query->orderBy('name');
            },
        ])
            ->orderBy('name')
            ->get();

        return view('admin.detailed_quotations.create', compact('categories'));
    }


    /**
     * Store uploaded or manually created quotation.
     */
    
    /**
 * Store uploaded PDF or generate PDF from editor.
 */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Basic validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'category_id' => [
                'required',
                'integer',
                'exists:quotation_categories,id',
            ],

            'service_id' => [
                'required',
                'integer',
                'exists:quotation_services,id',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'pdf' => [
                'nullable',
                'file',
                'mimes:pdf',
                'mimetypes:application/pdf,application/x-pdf',
                'max:10240',
            ],

            'content' => [
                'nullable',
                'string',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | PDF or editor content must be provided
        |--------------------------------------------------------------------------
        */

        $hasUploadedPdf = $request->hasFile('pdf');

        $editorText = trim(
            html_entity_decode(
                strip_tags($request->input('content', ''))
            )
        );

        $hasEditorContent = $editorText !== '';


        if (! $hasUploadedPdf && ! $hasEditorContent) {
            return back()
                ->withInput()
                ->withErrors([
                    'pdf' =>
                        'Please upload a PDF or add proposal content in the editor.',
                    'content' =>
                        'Please add proposal content or upload an existing PDF.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Verify service belongs to category
        |--------------------------------------------------------------------------
        */

        $serviceIsValid = QuotationCategory::query()
            ->whereKey($validated['category_id'])
            ->whereHas('services', function ($query) use ($validated) {
                $query->whereKey($validated['service_id']);
            })
            ->exists();


        if (! $serviceIsValid) {
            return back()
                ->withInput()
                ->withErrors([
                    'service_id' =>
                        'Selected quotation service does not belong to the selected category.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Create private PDF path
        |--------------------------------------------------------------------------
        */

        $fileName = Str::uuid()->toString() . '.pdf';

        $path = 'detailed-quotations/' . $fileName;


        /*
        |--------------------------------------------------------------------------
        | Uploaded PDF gets priority
        |--------------------------------------------------------------------------
        */

        if ($hasUploadedPdf) {
            $request->file('pdf')->storeAs(
                'detailed-quotations',
                $fileName
            );

            $quotationType = 'uploaded';
            $content = null;
        }


        /*
        |--------------------------------------------------------------------------
        | Generate PDF from editor
        |--------------------------------------------------------------------------
        */

        else {
            $content = clean($validated['content']);

            $pdf = Pdf::loadView(
                'admin.detailed_quotations.pdf.manual',
                [
                    'proposalName' => $validated['name'],
                    'content' => $content,
                    'category' => QuotationCategory::find(
                        $validated['category_id']
                    ),
                    'price' => $validated['price'],
                ]
            )->setPaper('a4', 'portrait');


            Storage::put(
                $path,
                $pdf->output()
            );

            $quotationType = 'manual';
        }


        /*
        |--------------------------------------------------------------------------
        | Save quotation
        |--------------------------------------------------------------------------
        */

        DetailedQuotation::create([
            'name' => $validated['name'],

            'quotation_type' => $quotationType,

            'category_id' => $validated['category_id'],

            'service_id' => $validated['service_id'],

            'price' => $validated['price'],

            'content' => $content,

            'pdf_path' => $path,
        ]);


        return redirect()
            ->route('admin.detailed-quotations.index')
            ->with(
                'success',
                $quotationType === 'uploaded'
                    ? 'Proposal PDF uploaded successfully.'
                    : 'Proposal PDF generated successfully.'
            );
    }



    
    // 
    /**
     * Display quotation library.
     */
    public function index()
    {
        $quotations = DetailedQuotation::latest()
            ->paginate(20);

        return view('admin.detailed_quotations.index', compact('quotations'));
    }


   
    // public function create()
    // {
    //     $categories = QuotationCategory::with('services')
    //         ->orderBy('name')
    //         ->get();

    //     return view('admin.detailed_quotations.create', compact('categories'));
    // }


   
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => [
    //             'required',
    //             'string',
    //             'max:255',
    //         ],

    //         'pdf' => [
    //             'required',
    //             'file',
    //             'mimes:pdf',
    //             'mimetypes:application/pdf',
    //             'max:10240',
    //         ],
    //     ]);

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Store privately
    //     |--------------------------------------------------------------------------
    //     |
    //     | storage/app/detailed-quotations/
    //     |
    //     | No storage:link required.
    //     |
    //     */

    //     $file = $request->file('pdf');

    //     $fileName =
    //         Str::uuid()->toString() . '.pdf';

    //     $path = $file->storeAs(
    //         'detailed-quotations',
    //         $fileName
    //     );


    //     DetailedQuotation::create([
    //         'name' => $request->name,
    //         'pdf_path' => $path,
    //     ]);


    //     return redirect()
    //         ->route('admin.detailed-quotations.index')
    //         ->with(
    //             'success',
    //             'Detailed quotation uploaded successfully.'
    //         );
    // }


    /**
     * View PDF.
     *
     * Resource SHOW route is being used for PDF preview.
     */
    public function show(DetailedQuotation $detailedQuotation)
    {
        if (
            !$detailedQuotation->pdf_path ||
            !Storage::exists(
                $detailedQuotation->pdf_path
            )
        ) {
            abort(404, 'Quotation PDF not found.');
        }


        $absolutePath = Storage::path(
            $detailedQuotation->pdf_path
        );


        return response()->file(
            $absolutePath,
            [
                'Content-Type' => 'application/pdf',

                'Content-Disposition' =>
                    'inline; filename="' .
                    $this->safePdfName(
                        $detailedQuotation->name
                    ) .
                    '"',
            ]
        );
    }


    /**
     * Show edit form.
     */
    public function edit(
        DetailedQuotation $detailedQuotation
    ) {
        return view(
            'admin.detailed_quotations.edit',
            compact('detailedQuotation')
        );
    }


    /**
     * Update quotation.
     */
    public function update(
        Request $request,
        DetailedQuotation $detailedQuotation
    ) {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'pdf' => [
                'nullable',
                'file',
                'mimes:pdf',
                'mimetypes:application/pdf',
                'max:10240',
            ],
        ]);


        $detailedQuotation->name =
            $request->name;


        /*
        |--------------------------------------------------------------------------
        | Replace PDF only if new PDF uploaded
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('pdf')) {

            $file = $request->file('pdf');

            $newFileName =
                Str::uuid()->toString() . '.pdf';


            /*
             * Upload new file first.
             *
             * Old file is deleted only after successful upload.
             */

            $newPath = $file->storeAs(
                'detailed-quotations',
                $newFileName
            );


            if (!$newPath) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Unable to upload the new PDF.'
                    );
            }


            $oldPath =
                $detailedQuotation->pdf_path;


            $detailedQuotation->pdf_path =
                $newPath;


            $detailedQuotation->save();


            /*
             * Delete old PDF after DB update.
             */

            if (
                $oldPath &&
                Storage::exists($oldPath)
            ) {
                Storage::delete($oldPath);
            }

        } else {

            /*
             * Only name changed.
             */

            $detailedQuotation->save();
        }


        return redirect()
            ->route('admin.detailed-quotations.index')
            ->with(
                'success',
                'Detailed quotation updated successfully.'
            );
    }


    /**
     * Delete quotation + PDF.
     */
    public function destroy(
        DetailedQuotation $detailedQuotation
    ) {
        $pdfPath =
            $detailedQuotation->pdf_path;


        $detailedQuotation->delete();


        if (
            $pdfPath &&
            Storage::exists($pdfPath)
        ) {
            Storage::delete($pdfPath);
        }


        return redirect()
            ->route('admin.detailed-quotations.index')
            ->with(
                'success',
                'Detailed quotation deleted successfully.'
            );
    }


    /**
     * Safe filename for browser PDF preview.
     */
    private function safePdfName($name)
    {
        $name = trim((string) $name);

        $name = preg_replace(
            '/[^A-Za-z0-9\-_ ]/',
            '',
            $name
        );

        $name = trim($name);

        if ($name === '') {
            $name = 'quotation';
        }

        return $name . '.pdf';
    }

    public function publicShare(DetailedQuotation $quotation)
    {
        /*
        |--------------------------------------------------------------------------
        | CHECK PDF
        |--------------------------------------------------------------------------
        */

        if (
            !$quotation->pdf_path ||
            !Storage::exists(
                $quotation->pdf_path
            )
        ) {
            abort(
                404,
                'Quotation PDF not found.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SAFE DISPLAY NAME
        |--------------------------------------------------------------------------
        */

        $fileName = preg_replace(
            '/[^A-Za-z0-9\-_ ]/',
            '',
            $quotation->name
        );

        $fileName = trim($fileName);

        if (!$fileName) {
            $fileName = 'quotation';
        }

        $fileName .= '.pdf';


        /*
        |--------------------------------------------------------------------------
        | SERVE PRIVATE PDF
        |--------------------------------------------------------------------------
        |
        | Still NO storage:link.
        |
        */

        return response()->file(
            Storage::path(
                $quotation->pdf_path
            ),
            [
                'Content-Type' =>
                    'application/pdf',

                'Content-Disposition' =>
                    'inline; filename="' .
                    $fileName .
                    '"',
            ]
        );
    }




}



