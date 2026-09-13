<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{AdvanceServiceController, LeaveApplicationController, TimesheetController, StaffController, AssessmentController, AttendanceController, TasksController, PayslipController, SettingsController, PerformanceController, PerformanceCriteriaController, InventoryController, InventoryItemController, BranchController, ExpenseCategoryController, ExpenseManagerController, MyProfileController, UserController, StudentController, Updater, StageController, RecruitmentController, CandidateController, DepartmentController, DesignationController, LeadCategoryController, LeadController, DealController, CompanyController, QuotationController, InvoiceController, ShortListController, OnBoardingController, LeaveTypeController, PolicyController, HolidayController, EmailTemplateController, SubscriberController, EmailAutomationController, ProposalController, TaxController, VendorController, VendorContractController, PaymentTermController, CategoryController, ProductController, WarehouseController, StockMovementController, BomController, BomItemController, ProductionOrderController, ProductionConsumptionController, GrnController, ProformaController, SalesOrderController, DeliveryController, DispatchController, TrackingController, PaymentController, PurchaseRequisitionController, PurchaseOrderController, SupportController, SupportDepartmentController, RoleController, HSNController, BankDetailController, KraController, KpiController, CommonController, PurchaseBillController, PayableController, ProformaPaymentController, WarrantyClaimController, WarrantyController, SuspenseController, NotificationController, NotificationSettingController, OtpController, RfqController, VendorQuotationController, LeadNoteController, RecoveryController, VendorReturnController, SeoServiceController, SeoPlanController, SeoTaskTemplateController, SeoPlanClientController, SeoTeamTaskController, SeoTeamWorkController, SeoReportController, DailyUpdateTaskController, ProjectController, ProjectModuleController, ProjectSubModuleController, ProjectMessageController, UserProjectController, BacklinkCategoryController, BacklinkController, BacklinkAssignmentController, OnPageSeoCategoryController, OnPageSeoTaskController, OnPageSeoController, KeywordController, SeoProjectKeywordController, RequirementAttachmentController, RequirementCommentController, RequirementController, SubModuleReviewController, DetailedQuotationController, QuotationCategoryController, QuotationServiceController};
use App\Models\WarrantyClaim;

use App\Http\Controllers\SubscriptionCategoryController;

use App\Http\Controllers\ServiceTypeController;

use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubscriptionPaymentController;
use App\Http\Controllers\RenewalController;



//Admin's routes

Route::name('admin.')->prefix('admin')->middleware(['auth'])->group(function () {

    Route::post('/leads/import/prepare', [LeadController::class, 'prepareImport'])->name('leads.import.prepare');
    Route::get('/leads/import/mapping', [LeadController::class, 'importMapping'])->name('leads.import.mapping');

    Route::get('/leads/import/preview', [LeadController::class, 'importPreview'])->name('leads.import.preview');

    Route::get('/leads/import-history', [LeadController::class, 'importHistory'])->name('leads.import.history');

    Route::delete('/leads/rejected/bulk-delete', [LeadController::class, 'bulkDeleteRejected'])->name('lead.rejected.bulk-delete');

    // 

    Route::get('/quotation-categories', [QuotationCategoryController::class, 'index'])->name('quotation-categories.index');

    Route::delete(
        'quotation-categories/{quotationCategory}',
        [QuotationCategoryController::class, 'destroy']
    )->name('quotation-categories.destroy');

      Route::delete(
        'quotation-subcategories/{quotationService}',
        [QuotationServiceController::class, 'destroy']
    )->name('quotation-subcategories.destroy');


    Route::put(
        'quotation-subcategories/{quotationService}',
        [QuotationServiceController::class, 'update']
    )->name('quotation-subcategories.update');

      Route::post(
        'quotation-subcategories',
        [QuotationServiceController::class, 'store']
    )->name('quotation-subcategories.store');

     Route::put(
        'quotation-categories/{quotationCategory}',
        [QuotationCategoryController::class, 'update']
    )->name('quotation-categories.update');

      Route::post(
        'quotation-categories',
        [QuotationCategoryController::class, 'store']
    )->name('quotation-categories.store');



    Route::get(
        '/leads/import-history/{batch}/leads',
        [LeadController::class, 'importBatchLeads']
    )->name('leads.import.history.leads');

    Route::get(
        '/leads/import-history/{batch}/open',
        [LeadController::class, 'openImportBatch']
    )->name('leads.import.history.open');

    Route::get(
        '/leads/import-history/{batch}/download',
        [LeadController::class, 'downloadImportBatch']
    )->name('leads.import.history.download');

    Route::delete(
        '/leads/import-history/{batch}',
        [LeadController::class, 'deleteImportBatch']
    )->name('leads.import.history.delete');




    // 
     Route::post(
        '/leads/pipeline/lead-stage/{id}',
        [LeadController::class, 'updateStage']
    )->name('leads.pipeline.lead-stage');

    Route::post(
        '/leads/pipeline/proforma-stage/{id}',
        [LeadController::class, 'updateProformaStage']
    )->name('leads.pipeline.proforma-stage');

    Route::post(
        '/leads/pipeline/quotation-stage/{id}',
        [LeadController::class, 'updateQuotationStage']
    )->name('leads.pipeline.quotation-stage');

    // Keep / add this route for the Quick Proforma modal:
    Route::post(
        '/leads/quick-proforma/store',
        [LeadController::class, 'storeQuickProforma']
    )->name('leads.quick-proforma.store');


     Route::post(
        '/leads/quick-proforma/store',
        [LeadController::class, 'storeQuickProforma']
    )->name('leads.quick-proforma.store');


    Route::get('dashboard', function () {
        return view('admin.dashboard.index');
    })->name('dashboard');

    Route::get('accounting', function () {
        return view('admin.dashboard.acc');
    })->name('acc.dashboard');

    Route::get('crm', function () {
        return view('admin.dashboard.crm');
    })->name('crm.dashboard');

    //Timesheet
    Route::get('timesheet', [TimesheetController::class, 'index'])->name('timesheet');
    Route::post('timesheet/store', [TimesheetController::class, 'store'])->name('timesheet.store');
    Route::post('timesheet/update/{id}', [TimesheetController::class, 'update'])->name('timesheet.update');
    Route::get('timesheet/delete/{id}', [TimesheetController::class, 'delete'])->name('timesheet.delete');

    //Task manager
    Route::get('tasks/{tasks_type}', [TasksController::class, 'index'])->name('tasks');
    Route::post('task/store/{user_id?}', [TasksController::class, 'store'])->name('task.store');
    Route::post('task/update/{id}', [TasksController::class, 'update'])->name('task.update');
    Route::get('task/completion', [TasksController::class, 'task_completion'])->name('task.completion');
    Route::get('task/status', [TasksController::class, 'task_status'])->name('task.status');
    Route::get('task/delete/{id}', [TasksController::class, 'task_delete'])->name('task.delete');
    Route::post('task/sort', [TasksController::class, 'sort'])->name('task.sort');

    //Attendance
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::post('attendance/update/{id}', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::get('attendance/delete/{id}', [AttendanceController::class, 'delete'])->name('attendance.delete');

    //Leave application
    Route::get('leave-report', [LeaveApplicationController::class, 'index'])->name('leave.report');
    Route::post('leave-report/store', [LeaveApplicationController::class, 'store'])->name('leave.report.store');
    Route::post('leave-report/status/{id}', [LeaveApplicationController::class, 'change_status'])->name('leave.report.status');
    Route::get('leave-report/delete/{id}', [LeaveApplicationController::class, 'delete'])->name('leave.report.delete');


    //Staffs
    Route::get('staffs', [StaffController::class, 'index'])->name('staffs');
    Route::post('staff/store', [StaffController::class, 'store'])->name('staff.store');
    Route::post('staff/update/{user_id}', [StaffController::class, 'update'])->name('staff.update');
    Route::get('staff/delete/{user_id}', [StaffController::class, 'delete'])->name('staff.delete');
    Route::get('staff/status/{status}/{user_id}', [StaffController::class, 'staff_status'])->name('staff.status');
    Route::post('staff-sort/update', [StaffController::class, 'staff_sort'])->name('staff.sort.update');

    Route::get('staff/profile/{tab?}/{user_id?}', [StaffController::class, 'profile'])->name('staff.profile');
    Route::post('staff/profile-update/{user_id?}', [StaffController::class, 'profile_update'])->name('staff.profile.update');
    Route::post('staff/document/update/{user_id}', [StaffController::class, 'docupdate'])->name('staff.doc.update');
    Route::get('/staff/document/delete/{id}', [StaffController::class, 'deleteDocument'])->name('staff.doc.delete');


    //Performances
    Route::get('performance', [PerformanceController::class, 'index'])->name('performance');
    Route::post('performance/store', [PerformanceController::class, 'store'])->name('performance.store');
    Route::post('performance/update/{id}', [PerformanceController::class, 'update'])->name('performance.update');
    Route::get('performance/delete', [PerformanceController::class, 'delete'])->name('performance.delete');

    //Assessments
    Route::get('assessment', [AssessmentController::class, 'index'])->name('assessment');
    Route::post('assessment/store', [AssessmentController::class, 'store'])->name('assessment.store');
    Route::post('assessment/update/{id}', [AssessmentController::class, 'update'])->name('assessment.update');
    Route::get('assessment/delete/{id}', [AssessmentController::class, 'delete'])->name('assessment.delete');

    //Payslip
    Route::get('payslip', [PayslipController::class, 'index'])->name('payslip');
    Route::post('payslip/store', [PayslipController::class, 'store'])->name('payslip.store');
    Route::post('payslip/update/{id}', [PayslipController::class, 'update'])->name('payslip.update');
    Route::get('payslip/delete', [PayslipController::class, 'delete'])->name('payslip.delete');
    Route::get('payslip/download', [PayslipController::class, 'payslip_download'])->name('payslip.download');
    Route::get('payslip/send', [PayslipController::class, 'payslip_send_to_email'])->name('payslip.send');

    //Branch
    Route::get('branch', [BranchController::class, 'index'])->name('branch');
    Route::post('branch/store', [BranchController::class, 'store'])->name('branch.store');
    Route::post('branch/update/{id}', [BranchController::class, 'update'])->name('branch.update');
    Route::get('branch/delete/{id}', [BranchController::class, 'delete'])->name('branch.delete');

    //Inventory
    Route::get('inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::post('inventory/store', [InventoryController::class, 'store'])->name('inventory.store');
    Route::post('inventory/update/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::get('inventory/delete/{id}', [InventoryController::class, 'delete'])->name('inventory.delete');

    //Inventory
    Route::get('inventory/item', [InventoryItemController::class, 'index'])->name('inventory.item');
    Route::post('inventory/item/store', [InventoryItemController::class, 'store'])->name('inventory.item.store');
    Route::post('inventory/item/update/{id}', [InventoryItemController::class, 'update'])->name('inventory.item.update');
    Route::get('inventory/item/delete/{id}', [InventoryItemController::class, 'delete'])->name('inventory.item.delete');

    //Performance Criteria
    Route::get('performance-criteria', [PerformanceCriteriaController::class, 'index'])->name('performance.criteria');
    Route::post('performance-criteria/store', [PerformanceCriteriaController::class, 'store'])->name('performance.criteria.store');
    Route::post('performance-criteria/update/{id}', [PerformanceCriteriaController::class, 'update'])->name('performance.criteria.update');
    Route::get('performance-criteria/delete/{id}', [PerformanceCriteriaController::class, 'delete'])->name('performance.criteria.delete');

    //Settings
    Route::get('system-settings', [SettingsController::class, 'system_settings'])->name('system.settings');
    Route::post('system-settings/update', [SettingsController::class, 'update'])->name('system.settings.update');

    Route::post('system/logo/update', [SettingsController::class, 'update_logo'])->name('system.logo.update');

    Route::get('smtp-settings', [SettingsController::class, 'smtp_settings'])->name('smtp.settings');
    Route::post('smtp-settings/update', [SettingsController::class, 'update'])->name('smtp.settings.update');
    Route::get('system/about', [SettingsController::class, 'about'])->name('system.about');

    //My profile
    Route::get('my-profile/{tab?}/{user_id?}', [MyProfileController::class, 'index'])->name('my.profile');
    Route::post('my-profile/update/{user_id?}', [MyProfileController::class, 'update'])->name('my.profile.update');

    //Change Password
    Route::get('password/change', [MyProfileController::class, 'change_password'])->name('change.password');
    Route::post('password/update/{user_id?}', [MyProfileController::class, 'password_update'])->name('password.update');


    // Expense cateogry
    Route::get('expense/category/list', [ExpenseCategoryController::class, 'exp_category_list'])->name('exp.category.list');
    Route::post('expense/category/store', [ExpenseCategoryController::class, 'exp_category_store'])->name('exp.category.store');
    Route::post('expense/category/update/{id}', [ExpenseCategoryController::class, 'exp_category_update'])->name('exp.category.update');
    Route::get('expense/category/delete/{id}', [ExpenseCategoryController::class, 'exp_category_delete'])->name('exp.category.delete');

    // Expense manager
    Route::get('expense/manager/list', [ExpenseManagerController::class, 'exp_manager_list'])->name('exp.manager.list');
    Route::post('expense/manager/store', [ExpenseManagerController::class, 'exp_manager_store'])->name('exp.manager.store');
    Route::post('expense/manager/update/{id}', [ExpenseManagerController::class, 'exp_manager_update'])->name('exp.manager.update');
    Route::get('expense/manager/delete/{id}', [ExpenseManagerController::class, 'exp_manager_delete'])->name('exp.manager.delete');

    //updater
    Route::post('admin/addon/create', [Updater::class, 'update'])->name('addon.create');
    Route::post('admin/addon/update', [Updater::class, 'update'])->name('addon.update');
    Route::post('admin/product/update', [Updater::class, 'update'])->name('product.update');

    // Stage
    Route::get('stage', [StageController::class, 'index'])->name('stage.index');
    Route::post('stage/store', [StageController::class, 'store'])->name('stage.store');
    Route::get('stage/delete/{id}', [StageController::class, 'destroy'])->name('stage.delete');

    // Recruitment
    Route::get('recruitment', [RecruitmentController::class, 'index'])->name('recruitment.index');
    Route::post('recruitment/store', [RecruitmentController::class, 'store'])->name('recruitment.store');
    Route::get('recruitment/delete/{id}', [RecruitmentController::class, 'destroy'])->name('recruitment.destroy');
    Route::patch('recruitment/update/{id}', [RecruitmentController::class, 'update'])->name('recruitment.update');
    Route::get('/recruitment/{id}/stages', [RecruitmentController::class, 'getStages']);
    Route::get('/recruitment/show/{id}', [RecruitmentController::class, 'show'])->name('recruitment.show');


    // Candidate
    Route::get('candidate', [CandidateController::class, 'index'])->name('candidate.index');
    Route::post('candidate/store', [CandidateController::class, 'store'])->name('candidate.store');
    Route::get('candidate/delete/{id}', [CandidateController::class, 'destroy'])->name('candidate.delete');
    Route::post('candidate/update/{id}', [CandidateController::class, 'update'])->name('candidate.update');
    Route::post('candidate/{id}/update-stage', [CandidateController::class, 'updateStage'])->name('candidate.updateStage');
    // Route::get('candidate/{id}', [CandidateController::class, 'sendEmail'])->name('candidate.send.mail');
    Route::post('candidate/send-mail', [CandidateController::class, 'sendMail'])->name('candidate.sendMail');
    Route::post('candidate/update-is-final', [CandidateController::class, 'updateIsFinal'])
        ->name('candidate.updateIsFinal');
    Route::get('candidate/show/{id}', [CandidateController::class, 'show'])->name('candidate.show');


    // Departments
    Route::get('departments', [DepartmentController::class, 'index'])->name('department.index');
    Route::post('department/store', [DepartmentController::class, 'store'])->name('department.store');
    Route::post('department/update/{id}', [DepartmentController::class, 'update'])->name('department.update');
    Route::get('department/delete/{id}', [DepartmentController::class, 'delete'])->name('department.delete');

    // Designation
    Route::get('designation', [DesignationController::class, 'index'])->name('designation.index');
    Route::post('designation/store', [DesignationController::class, 'store'])->name('designation.store');
    Route::post('designation/update/{id}', [DesignationController::class, 'update'])->name('designation.update');
    Route::get('designation/delete/{id}', [DesignationController::class, 'delete'])->name('designation.delete');

    // Ajax code

    Route::get('/get-departments', [StaffController::class, 'getDepartmentsByBranch'])->name('getDepartmentsByBranch');
    Route::get('/get-designations', [StaffController::class, 'getDesignationsByDepartment'])->name('getDesignationsByDepartment');



    // Lead Category
    Route::get('/lead-from', [LeadCategoryController::class, 'index'])->name('leadcategory.index');
    Route::post('/lead-add', [LeadCategoryController::class, 'store'])->name('leadcategory.store');
    Route::post('/leadcat-update/{id}', [LeadCategoryController::class, 'update'])->name('leadcategory.update');
    Route::get('/lead-delete/{id}', [LeadCategoryController::class, 'destroy'])->name('leadcategory.delete');

    // Lead
    Route::get('/leads/{id?}', [LeadController::class, 'index'])->name('leads.index');
    Route::post('/leads-store', [LeadController::class, 'store'])->name('leads.store');
    Route::post('/lead-update/{id}', [LeadController::class, 'update'])->name('leads.update');
    Route::post('/lead/change-status/{id}', [LeadController::class, 'statuschange'])->name('leads.change_status');
    Route::get('/call-again/{id?}', [LeadController::class, 'callAgain'])->name('leads.callagain');
    Route::get('/rejected/{id?}', [LeadController::class, 'rejectedLead'])->name('lead.rejected');
    Route::get('lead/delete/{id}', [LeadController::class, 'destroy'])->name('lead.delete');


    Route::post('/leads/quick-quotation/store', [LeadController::class, 'storeQuickQuotation'])->name('leads.quick-quotation.store');

    Route::post('/leads/{id}/mark-contacted', [LeadController::class, 'markContacted'])->name('leads.mark-contacted');

    Route::get('/leads-actions', [LeadController::class, 'leadActionsIndex'])->name('leads.actions.index');
    Route::post('/leads/{lead}/action', [LeadController::class, 'storeLeadAction'])->name('leads.action.store');

    Route::patch('/leads-actions/{action}', [LeadController::class, 'updateLeadActionType'])->name('leads.actions.update');
    Route::post('/leads/{id}/follow-up', [LeadController::class, 'storeFollowUp'])->name('leads.follow-up.store');

    Route::resource('detailed-quotations', DetailedQuotationController::class)->names('detailed-quotations');

    Route::post('/leads/{id}/detailed-quotation/send', [LeadController::class, 'sendDetailedQuotation'])->name('leads.detailed-quotation.send');

    Route::delete('/leads/bulk-delete', [LeadController::class, 'bulkDelete'])->name('leads.bulk-delete');

    


    // Deals
    Route::get('/deals', [DealController::class, 'index'])->name('deals.index');
    Route::post('/deals/update-stage/{id}', [DealController::class, 'updateStage']);
    Route::post('/deals/store/', [DealController::class, 'store'])->name('deals.store');
    Route::post('/deals/update/{id}', [DealController::class, 'update'])->name('deals.update');
    Route::post('/deals/update-date/{id}', [DealController::class, 'updateDate']);

    // Company
    Route::get('organizations', [CompanyController::class, 'index'])->name('company.index');
    Route::post('/organization-store', [CompanyController::class, 'store'])->name('company.store');
    Route::post('/organization/update/{id}', [CompanyController::class, 'update'])->name('company.update');
    Route::get('organization/delete/{id}', [CompanyController::class, 'destroy'])->name('company.delete');

    // Quotation
    Route::get('/quotation', [QuotationController::class, 'index'])->name('quotation.index');
    Route::get('/quotation/create/{id?}', [QuotationController::class, 'create'])->name('quotation.create');
    Route::post('/quotations/store', [QuotationController::class, 'store'])->name('quotation.save');
    Route::get('quotation/view/{id}', [QuotationController::class, 'show'])->name('quotation.view');
    Route::get('quotation/edit/{id}', [QuotationController::class, 'edit'])->name('quotation.edit');
    Route::post('quotation/update/{id}', [QuotationController::class, 'update'])->name('quotation.update');
    Route::get('quotation/print/{id}', [QuotationController::class, 'printQuotation'])->name('quotation.print');
    Route::get('quotation/delete/{id}', [QuotationController::class, 'destroy'])->name('quotation.delete');

    // Invoice
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');


    Route::get('/invoice/dispatch', [InvoiceController::class, 'dispatchinvoice'])->name('dispatch.invoice.index');

    Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('/invoice/store', [InvoiceController::class, 'store'])->name('invoice.store');
    // Route::get('/invoice/view/{id}', [InvoiceController::class, 'show'])->name('invoice.view');
    Route::get('/invoice/{id}/view', [InvoiceController::class, 'view'])->name('invoice.view');
    Route::get('/invoice/{id}/pdf', [InvoiceController::class, 'pdf'])->name('invoice.pdf');
    Route::get('invoice/edit/{id}', [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::post('invoice/update/{id}', [InvoiceController::class, 'update'])->name('invoice.update');
    Route::get('invoice/delete/{id}', [InvoiceController::class, 'destroy'])->name('invoice.delete');

    // Shortlist
    Route::get('/shortlist', [ShortListController::class, 'index'])->name('shortlist.index');

    // Oonboarding
    Route::get('/on-boarding', [OnBoardingController::class, 'index'])->name('onboarding.index');
    Route::post('/on-boarding/store', [OnBoardingController::class, 'store'])->name('onboarding.store');
    Route::get('/get-stage-template/{id}', [OnBoardingController::class, 'getStageTemplate']);
    Route::post('/send-stage-mail', [OnBoardingController::class, 'sendStageMail']);
    Route::post('/on-boarding/{id}/update-stage', [OnBoardingController::class, 'updateStage'])->name('onboarding.updateStage');
    Route::get('/selected/candidates', [OnBoardingController::class, 'SelectedCandi'])->name('selected.candi');
    Route::get('/candidate-rejected', [OnBoardingController::class, 'rejectedCandi'])->name('rejected.candidate');

    Route::post('candidate/type/update/{id}', [CandidateController::class, 'updateTypeAndRedirect'])
        ->name('candidate.updateTypeAndRedirect');
    Route::post('candidate/emp/{id}', [CandidateController::class, 'candiemp'])->name('candidate.make_emp');
    Route::post('/onboading/stage/update/{id}', [OnBoardingController::class, 'onbordingstage'])->name('onboardingstage.update');

    // Type
    Route::get('type', [LeaveTypeController::class, 'index'])->name('type.index');
    Route::post('type/store', [LeaveTypeController::class, 'store'])->name('type.store');
    Route::post('type/update/{id}', [LeaveTypeController::class, 'update'])->name('type.update');
    Route::get('type/delete/{id}', [LeaveTypeController::class, 'delete'])->name('type.delete');

    // Policy
    Route::get('policy', [PolicyController::class, 'index'])->name('policy.index');
    Route::post('policy/store', [PolicyController::class, 'store'])->name('policy.store');
    Route::post('policy/update/{id}', [PolicyController::class, 'update'])->name('policy.update');
    Route::get('policy/delete/{id}', [PolicyController::class, 'delete'])->name('policy.delete');
    Route::get('/policy/show/{id}', [PolicyController::class, 'show'])->name('policy.show');


    Route::get('holiday', [HolidayController::class, 'index'])->name('holiday.index');
    Route::post('holiday/store', [HolidayController::class, 'store'])->name('holiday.store');
    Route::post('holiday/update/{id}', [HolidayController::class, 'update'])->name('holiday.update');
    Route::get('holiday/delete/{id}', [HolidayController::class, 'delete'])->name('holidays.delete');

    Route::post('/payslip/approve', [PayslipController::class, 'approve'])
        ->name('payslip.approve');

    // EmailTemplate
    Route::get('email-template', [EmailTemplateController::class, 'index'])->name('emailtemplate.index');
    Route::get('email-template/add', [EmailTemplateController::class, 'add'])->name('emailtemplate.add');
    Route::post('/email-template/store', [EmailTemplateController::class, 'store'])->name('email.template.store');
    Route::get('email-template/edit/{id}', [EmailTemplateController::class, 'edit'])->name('emailtemplate.edit');
    Route::post('email-template/update/{id}', [EmailTemplateController::class, 'update'])->name('emailtemplate.update');
    Route::get('email-template/delete/{id}', [EmailTemplateController::class, 'delete'])->name('emailtemplate.delete');

    // Subscriber
    Route::get('subscriber', [SubscriberController::class, 'index'])->name('subscriber.index');
    Route::post('subscriber/store', [SubscriberController::class, 'store'])->name('subscriber.store');
    Route::post('subscriber/update/{id}', [SubscriberController::class, 'update'])->name('subscriber.update');
    Route::get('subscriber/delete/{id}', [SubscriberController::class, 'delete'])->name('subscriber.delete');

    // Email Automation
    Route::get('email-automation', [EmailAutomationController::class, 'index'])->name('emailautomation.index');
    Route::get('email-automation/create', [EmailAutomationController::class, 'add'])->name('emailautomation.add');
    Route::get('email-automation/edit/{id}', [EmailAutomationController::class, 'edit'])->name('emailautomation.edit');
    Route::post('email-automation/store', [EmailAutomationController::class, 'store'])->name('emailautomation.store');
    Route::post('email-automation/update/{id}', [EmailAutomationController::class, 'update'])->name('emailautomation.update');
    Route::get('email-automation/delete/{id}', [EmailAutomationController::class, 'destroy'])->name('emailautomation.delete');

    // Proposals
    Route::get('proposals', [ProposalController::class, 'index'])->name('proposals.index');
    Route::get('proposals/create', [ProposalController::class, 'create'])->name('proposals.create');
    Route::post('proposals/store', [ProposalController::class, 'store'])->name('proposals.store');
    Route::get('proposals/edit/{id}', [ProposalController::class, 'edit'])->name('proposals.edit');
    Route::post('proposals/update/{id}', [ProposalController::class, 'update'])->name('proposals.update');
    Route::get('proposals/delete/{id}', [ProposalController::class, 'destroy'])->name('proposals.delete');

    // Tax
    Route::get('tax', [TaxController::class, 'index'])->name('tax.index');
    Route::post('tax/store', [TaxController::class, 'store'])->name('tax.store');
    Route::post('tax/update/{id}', [TaxController::class, 'update'])->name('tax.update');
    Route::get('tax/delete/{id}', [TaxController::class, 'delete'])->name('tax.delete');

    // Route not listed
    // Vendor
    Route::get('vendor', [VendorController::class, 'index'])->name('vendor.index');
    Route::post('vendor/store', [VendorController::class, 'store'])->name('vendor.store');
    Route::post('vendor/update/{id}', [VendorController::class, 'update'])->name('vendor.update');
    Route::get('vendor/delete/{id}', [VendorController::class, 'delete'])->name('vendor.delete');
    Route::post('vendor-rate/{id}', [VendorController::class, 'rating'])->name('vendor.rating');

    // Vendor Contract
    Route::get('vendor-contract', [VendorContractController::class, 'index'])->name('vendor.contract');
    Route::post('vendor/contract/store', [VendorContractController::class, 'store'])->name('vendor.contract.store');
    Route::post('vendor-contract/update/{id}', [VendorContractController::class, 'update'])->name('vendor.contract.update');
    Route::get('vendor-contract/delete/{id}', [VendorContractController::class, 'delete'])->name('vendor.contract.delete');

    // Vendor PaymentTerm
    Route::get('vendor-payment-term', [PaymentTermController::class, 'index'])->name('vendorterm.payment');
    Route::post('vendor-payment-term/store', [PaymentTermController::class, 'store'])->name('vendorterm.store');
    Route::post('vendor-payment-term/update/{id}', [PaymentTermController::class, 'update'])->name('vendorterm.update');
    Route::get('vendor-payment-term/delete/{id}', [PaymentTermController::class, 'delete'])->name('vendorterm.delete');

    //  Category
    Route::get('product-category', [CategoryController::class, 'index'])->name('category.index');
    Route::post('product-category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::post('product-category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('product-category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

    // Prodduct
    Route::get('products', [ProductController::class, 'index'])->name('product.index');
    Route::post('product/store', [ProductController::class, 'store'])->name('product.store');
    Route::post('product/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::get('product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

    // Warehouse
    Route::get('warehouse', [WarehouseController::class, 'index'])->name('warehouse.index');
    Route::post('warehouse/store', [WarehouseController::class, 'store'])->name('warehouse.store');
    Route::post('warehouse/update/{id}', [WarehouseController::class, 'update'])->name('warehouse.update');
    Route::get('warehouse/delete/{id}', [WarehouseController::class, 'delete'])->name('warehouse.delete');

    // Stock Movement
    Route::get('stock-movement', [StockMovementController::class, 'index'])->name('stockmovement.index');
    Route::post('stock-movement/store', [StockMovementController::class, 'store'])->name('stockmovement.store');
    Route::post('stock-movement/update/{id}', [StockMovementController::class, 'update'])->name('stockmovement.update');
    Route::get('stock-movement/delete/{id}', [StockMovementController::class, 'delete'])->name('stockmovement.delete');
    Route::get('stock-movement/show/{id}', [StockMovementController::class, 'show'])->name('stockmovement.show');
    Route::get('stock-check', [StockMovementController::class, 'stockCheck'])->name('stock.check');

    // BOM
    Route::get('bom', [BomController::class, 'index'])->name('bom.index');
    Route::get('bom/create', [BomController::class, 'create'])->name('bom.create');
    Route::post('bom/store', [BomController::class, 'store'])->name('bom.store');
    Route::get('bom/edit/{id}', [BomController::class, 'edit'])->name('bom.edit');
    Route::post('bom/update/{id}', [BomController::class, 'update'])->name('bom.update');
    Route::get('bom/delete/{id}', [BomController::class, 'delete'])->name('bom.delete');
    Route::get('bom/get-finished-product/{bom_id}', [BomController::class, 'getFinishedProduct']);
    Route::get('bom/show/{id}', [BomController::class, 'show'])->name('bom.show');


    // Bom Items
    Route::get('bom-items', [BomItemController::class, 'index'])->name('bomitem.index');
    Route::post('bom-items/store', [BomItemController::class, 'store'])->name('bomitem.store');
    Route::post('bom-items/update/{id}', [BomItemController::class, 'update'])->name('bomitem.update');
    Route::get('bom-items/delete/{id}', [BomItemController::class, 'delete'])->name('bomitem.delete');

    // Product
    Route::get('production-order', [ProductionOrderController::class, 'index'])->name('productionorder.index');
    Route::post('production-order/store', [ProductionOrderController::class, 'store'])->name('productionorder.store');
    Route::post('production-order/update/{id}', [ProductionOrderController::class, 'update'])->name('productionorder.update');
    Route::get('production-order/delete/{id}', [ProductionOrderController::class, 'delete'])->name('productionorder.delete');
    Route::get('production-order/show/{id}', [ProductionOrderController::class, 'show'])->name('productionorder.show');

    // Production consumption
    Route::get('production-consumption', [ProductionConsumptionController::class, 'index'])->name('productionconsumption.index');
    Route::post('production-consumption/store', [ProductionConsumptionController::class, 'store'])->name('productionconsumption.store');
    Route::post('production-consumption/update/{id}', [ProductionConsumptionController::class, 'update'])->name('productionconsumption.update');
    Route::get('production-consumption/delete/{id}', [ProductionConsumptionController::class, 'delete'])->name('productionconsumption.delete');


    // Grn
    Route::get('grn', [GrnController::class, 'index'])->name('grn.index');
    Route::post('grn/store', [GrnController::class, 'store'])->name('grn.store');
    Route::get('grn/create', [GrnController::class, 'create'])->name('grn.create');
    Route::post('grn/update/{id}', [GrnController::class, 'update'])->name('grn.update');
    Route::get('grn/show/{id}', [GrnController::class, 'show'])->name('grn.show');

    // Proforma
    Route::get('proforma', [ProformaController::class, 'index'])->name('proforma.index');
    Route::get('performa/create', [ProformaController::class, 'create'])->name('proforma.create');
    Route::post('proforma/store', [ProformaController::class, 'store'])->name('proforma.store');
    Route::get('/proforma/{id}/view', [ProformaController::class, 'view'])->name('proforma.view');
    Route::get('/proforma/{id}/pdf', [ProformaController::class, 'pdf'])->name('proforma.pdf');
    Route::get('proforma/edit/{id}', [ProformaController::class, 'edit'])->name('proforma.edit');
    Route::post('proforma/update/{id}', [ProformaController::class, 'update'])->name('proforma.update');
    Route::get('proforma/payments/{id}', [ProformaPaymentController::class, 'index'])->name('proforma.pay');
    Route::post('performa/payment', [ProformaPaymentController::class, 'payment'])->name('proforma.payment');
    Route::get('proforma/payment/rec/{id}', [ProformaPaymentController::class, 'paymentrecipt'])->name('proforma.recipt');
    // routes/web.php
    Route::get('payment-receipt/{payment}/pdf', [ProformaPaymentController::class, 'pdf'])
        ->name('payment.receipt.pdf');


    Route::get('/sales-orders/convert/{id}', [SalesOrderController::class, 'convertFromProforma'])->name('salesorder.convert');

    // Sales Order
    Route::get('sales-order', [SalesOrderController::class, 'index'])->name('salesorders.index');
    Route::post('sales-order/store', [SalesOrderController::class, 'store'])->name('salesorder.store');
    Route::get('/sales-order/view/{id}', [SalesOrderController::class, 'show'])->name('salesorder.view');
    Route::get('/invoice/generate/{id}', [InvoiceController::class, 'generateFromSalesOrder'])->name('invoice.generate');
    Route::get('/packing/generate/{id}', [InvoiceController::class, 'generatepacking'])->name('packing.complete');
    Route::post('/admin/sales-order/update-status', [SalesOrderController::class, 'updateStatus'])->name('salesorder.updateStatus');


    // Delivery
    Route::get('delivery', [DeliveryController::class, 'index'])->name('delivery.ready');
    Route::get('packing', [DeliveryController::class, 'packing'])->name('packing.ready');

    Route::get('invoice/{id}/ready-to-delivery', [DeliveryController::class, 'markReadyToDelivery'])->name('invoice.readyToDelivery');

    // Dispatch
    Route::get('dispatch/{id}/form', [DispatchController::class, 'dispatchForm'])->name('dispatch.form');
    Route::post('dispatch/{id}', [DispatchController::class, 'submitDispatch'])->name('dispatch.submit');
    Route::get('dispatch', [DispatchController::class, 'index'])->name('dispatch.list');

    // Order Tracking
    Route::get('tracking/{id}', [TrackingController::class, 'show'])->name('tracking.timeline');

    Route::post('tracking/{id}/add', [TrackingController::class, 'addEvent'])->name('tracking.add');
    Route::get('admin/delivery/{id}/pdf', [DispatchController::class, 'deliveryNotePdf'])->name('dispatch.delivery_pdf');


    // Payment
    Route::post('/payment/store', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/payment/{id}/view', [PaymentController::class, 'view'])->name('payment.view');
    Route::get('/payment/{id}/pdf', [PaymentController::class, 'pdf'])->name('payment.pdf');

    Route::get('receivable', [InvoiceController::class, 'show'])->name('receivable.show');

    // Purchase Requisition
    Route::get('purchase-requisition', [PurchaseRequisitionController::class, 'index'])->name('purchase.index');
    Route::get('purchase-requisition/convert/{id}', [PurchaseRequisitionController::class, 'convertpurchase'])->name('pr.convert');
    Route::get('purchase-requisition/view/{id}', [PurchaseRequisitionController::class, 'show'])->name('purchase.view');


    Route::post('purchase-order/convert/{id}', [PurchaseOrderController::class, 'purchaseorderconvert'])->name('purchase.order');
    Route::get('purchase-order', [PurchaseOrderController::class, 'index'])->name('purchaseorder.index');
    Route::get('purchase-order/view/{id}', [PurchaseOrderController::class, 'show'])->name('purchaseorder.view');

    // Support Ticket
    Route::get('supports', [SupportController::class, 'index'])->name('support.index');
    Route::post('support-store', [SupportController::class, 'store'])->name('support.store');

    // Support Department
    Route::get('support-department', [SupportDepartmentController::class, 'index'])->name('support.department.index');
    Route::post('support-department/store', [SupportDepartmentController::class, 'store'])->name('support.department.store');
    Route::post('support-department-update/{id}', [SupportDepartmentController::class, 'update'])->name('support.department.update');
    Route::get('support-department-delete/{id}', [SupportDepartmentController::class, 'delete'])->name('support.department.delete');


    Route::get('/support/{id}', [SupportController::class, 'show'])->name('support.show');
    Route::post('/support/reply', [SupportController::class, 'reply'])->name('support.reply');
    // Route::get('/support/fetch/{id}', [SupportController::class, 'fetchMessages']);

    Route::get('/support/fetch/{id}', [SupportController::class, 'fetchMessages'])->name('support.fetch');

    Route::post('/support/close-ticket/{id}', [SupportController::class, 'closeTicket'])->name('support.closeTicket');

    // Roles
    Route::get('roles', [RoleController::class, 'index'])->name('role.index');
    Route::post('roles-store', [RoleController::class, 'store'])->name('roles.store');
    Route::post('roles-update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::get('roles-delete/{id}', [RoleController::class, 'destroy'])->name('roles.delete');
    Route::get('roles/create', [RoleController::class, 'create'])->name('role.create');
    Route::get('roles/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');

    // User
    Route::get('users', [UserController::class, 'index'])->name('user.index');
    Route::post('users-update/{id}', [UserController::class, 'update'])->name('users.update');

    //Hsn
    Route::post('hsn/store', [HSNController::class, 'store'])->name('hsn.store');
    Route::delete('hsn/{id}', [HsnController::class, 'destroy'])->name('hsn.delete');

    // Tax Delete

    Route::delete('tax/{id}', [TaxController::class, 'destroy'])
        ->name('tax.delete');


    // Bank Details
    Route::post('bank-details/store', [BankDetailController::class, 'store'])->name('bank.store');
    Route::delete('bank-details/{id}', [BankDetailController::class, 'destroy'])->name('bank.delete');

    // Kra
    Route::get('kra', [KraController::class, 'index'])->name('kra.index');
    Route::post('kra/store', [KraController::class, 'store'])->name('kra.store');
    Route::post('kra/update/{id}', [KraController::class, 'update'])->name('kra.update');
    Route::get('kra/delete/{id}', [KraController::class, 'delete'])->name('kra.delete');

    // Kpi
    Route::get('kpi', [KpiController::class, 'index'])->name('kpi.index');
    Route::post('kpi/store', [KpiController::class, 'store'])->name('kpi.store');
    Route::post('kpi/update/{id}', [KpiController::class, 'update'])->name('kpi.update');
    Route::get('kpi/delete/{id}', [KpiController::class, 'delete'])->name('kpi.delete');

    // Attendence
    Route::get('atten', [CommonController::class, 'atten'])->name('atten.index');

    Route::post('/employee/kpi/store', [CommonController::class, 'store'])
        ->name('employee.kpi.store');


    // Kra Update
    Route::get('kra/completion/{id}/{user}', [KraController::class, 'completion'])->name('kra.completion');
    Route::get('kra/status/{id}/{user}', [KraController::class, 'status'])->name('kra.status');

    // Purchase Bills
    Route::get('purchase', [PurchaseBillController::class, 'index'])->name('purchase.bills');
    Route::get('purchase-bills/{bill}', [PurchaseBillController::class, 'show'])->name('purchase-bills.show');
    Route::post('purchase-bills/{bill}/pay', [PurchaseBillController::class, 'pay'])
        ->name('purchase-bills.pay');

    Route::get('purchase-bills/{bill}/pdf', [PurchaseBillController::class, 'pdf'])
        ->name('purchase-bills.pdf');
    Route::get('purchase-receipts/{payment}/pdf', [PurchaseBillController::class, 'recept'])->name('purchase-receipts.pdf');

    Route::get('/payables', [PayableController::class, 'index'])
        ->name('payables.index');

    Route::get(
        'purchase-receipts/{payment}',
        [PayableController::class, 'show']
    )->name('purchase-receipts.show');

    Route::get(
        'purchase-receipts/{payment}/pdf',
        [PayableController::class, 'pdf']
    )->name('purchase-receipts.pdf');

    Route::get(
        'payables/vendor/{supplier}',
        [PayableController::class, 'vendorBills']
    )->name('vendor.payables.bills');




    // Order Status changes
    Route::post('approve-order/{id}', [ProductionOrderController::class, 'approveOrder'])->name('approved.order');
    Route::get('production-manufacturing', [ProductionConsumptionController::class, 'manufacturing'])->name('product.manufacturing');
    Route::post('product-manufacture/{id}', [ProductionConsumptionController::class, 'productManufacture'])->name('product.manufacture');

    Route::get('ledger/{id}', [CompanyController::class, 'customerLedger'])->name('ledger.show');


    Route::post('/company/rate/{id}', [CompanyController::class, 'rate'])->name('company.rate');
    Route::post('/company/block/{id}', [CompanyController::class, 'block'])->name('company.block');

    Route::get('advance-service', [AdvanceServiceController::class, 'index'])->name('advance.service');
    Route::post('advance-services/store', [AdvanceServiceController::class, 'store'])->name('advance.service.store');

    Route::get('/warranty', [WarrantyController::class, 'index'])->name('warranty.index');
    Route::post('/warranty/store', [WarrantyController::class, 'store'])->name('warranty.store');
    Route::post('/warranty/check-user', [WarrantyController::class, 'checkUser'])
        ->name('warranty.check-user');


    Route::get('warranty/claim', [WarrantyClaimController::class, 'index'])->name('WarrantyClaim.index');
    Route::post('/fetch-warranty', [WarrantyClaimController::class, 'fetchWarranty'])
        ->name('warranty.claim.fetch-warranty');
    Route::post('/claim', [WarrantyClaimController::class, 'store'])
        ->name('warranty.claim.store');
    Route::post('/warranty-claim/status/{id}', [WarrantyClaimController::class, 'updateStatus'])
        ->name('warranty.claim.status.update');

    Route::post('/warranty-claim/{id}/assign-vendor', [WarrantyClaimController::class, 'assignVendor'])
        ->name('warranty.claim.assign.vendor');

    Route::get('/warranty-claims/{id}', [WarrantyClaimController::class, 'warrantyHistory'])
        ->name('warranty.claim.show');

    Route::get(
        '/warranty/user-products/{user}',
        [WarrantyController::class, 'userProducts']
    )
        ->name('warranty.user.products');

    Route::get('/suspense-entry', [SuspenseController::class, 'index'])->name('suspense.index');
    Route::post('/suspense-entry/store', [SuspenseController::class, 'store'])->name('suspense.store');



    Route::post('/service/approve/{id}', [AdvanceServiceController::class, 'approve'])
        ->name('service.approve');


    Route::get('/attendance/export', [CommonController::class, 'exportAttendance'])
        ->name('attendance.export');

    Route::get('/recruitment/export', [RecruitmentController::class, 'export'])->name('recruitment.export');
    Route::post('/recruitment/import', [RecruitmentController::class, 'import'])->name('recruitment.import');
    Route::get('/recruitment/sample-csv', [RecruitmentController::class, 'downloadSampleCsv'])
        ->name('recruitment.sample.csv');
    Route::get('/candidate/export', [CandidateController::class, 'exportCandidates'])->name('candidate.export');

    Route::post('/candidate/import', [CandidateController::class, 'importCandidates'])->name('candidate.import');
    Route::get('/candidate/sample-csv', [CandidateController::class, 'downloadSampleCsv'])
        ->name('candidate.sample.csv');

    Route::get('/stage/{stage}/candidates/export', [CandidateController::class, 'exportStageCandidates'])
        ->name('stage.candidates.export');
    Route::get('/shortlist/export', [CandidateController::class, 'exportShortlists'])
        ->name('shortlist.export');
    Route::get('/onboarding-stage/{stage}/export', [CandidateController::class, 'exportOnboardingStageCandidates'])
        ->name('onboarding.stage.export');
    Route::get('/candidate/employee/export', [CandidateController::class, 'exportEmployeeCandidates'])
        ->name('candidate.employee.export');

    Route::get('/leads/export/{id?}', [LeadController::class, 'export'])
        ->name('leads.export');

        // 


    Route::post('/leads/import', [LeadController::class, 'import'])->name('leads.import');

    // Route::post('/leads/import', [LeadController::class, 'import'])->name('leads.import');
    Route::get('/leads/sample-csv', [LeadController::class, 'downloadSampleCsv'])->name('leads.sample.csv');




    Route::get('/notifications/unread', [NotificationController::class, 'unread'])
        ->name('notifications.unread');

    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');



    // Notiifcation Setting

    Route::get('notification-settings', [NotificationSettingController::class, 'index'])->name('notification-settings.index');
    Route::get('notification-settings/create', [NotificationSettingController::class, 'create'])->name('notification-settings.create');
    Route::post('notification-settings/store', [NotificationSettingController::class, 'store'])->name('notification-settings.store');
    Route::get('notification-settings/edit/{id}', [NotificationSettingController::class, 'edit'])->name('notification-settings.edit');
    Route::post('notification-settings/update/{id}', [NotificationSettingController::class, 'update'])->name('notification-settings.update');
    Route::get('notification-settings/delete/{id}', [NotificationSettingController::class, 'destroy'])->name('notification-settings.delete');

    Route::post('/send-otp', [OtpController::class, 'sendOtp'])->name('send.otp');
    Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('verify.otp');


    Route::post('dispatch/staus/{id}', [DispatchController::class, 'dispatchStatus'])->name('dispatch.status');

    Route::get('/rfq', [RfqController::class, 'index'])->name('rfq.index'); // ✅ ADD THIS
    Route::post('/rfq/store', [RfqController::class, 'store'])->name('rfq.store');
    Route::get('rfq/{id}', [RfqController::class, 'show'])->name('rfq.show');
    Route::get('rfq/send/{id}', [RfqController::class, 'send'])->name('rfq.send');

    Route::get('/quotation/{rfq}', [VendorQuotationController::class, 'create'])->name('vendor.quotation.create');
    Route::post('/quotation/store', [VendorQuotationController::class, 'store'])->name('vendor.quotation.store');
    Route::get('/admin/rfq/{id}/quotations', [VendorQuotationController::class, 'quotations'])->name('rfq.quotations');
    Route::get('/vendor/quotation/{id}', [VendorQuotationController::class, 'view'])->name('vendor.quotation.view');


    Route::get('/rfq/{id}/compare', [PurchaseOrderController::class, 'compare'])->name('rfq.compare');

    Route::get('/quotation/approve/{id}', [PurchaseOrderController::class, 'approve'])->name('quotation.approve');
    Route::get('/quotation/reject/{id}', [PurchaseOrderController::class, 'reject'])->name('quotation.reject');

    Route::get('/po/{id}', [PurchaseOrderController::class, 'showPO'])->name('po.show');


    Route::post('selected/candi/{id}', [OnBoardingController::class, 'delete'])->name('selected.candi.delete');

    // Lead Notes
    Route::post('lead/notes', [LeadNoteController::class, 'store'])->name('lead.notes');
    Route::get('lead/note/history/{id}', [LeadNoteController::class, 'history'])->name('lead.note.history');
    Route::get('salespipeline', [LeadController::class, 'salespipeline'])->name('salespipeline');
    // Route::post('/update-lead-stage/{id}', [LeadController::class, 'updateStage'])->name('admin.leads.update_stage');
    Route::post('/service/status/{id}', [WarrantyClaimController::class, 'serviceStatus'])->name('service.status');


    Route::get('company/product/', [CommonController::class, 'vendorInventory'])->name('company.products');
    Route::get('replaced/product/{id?}/{vendor_id?}', [CommonController::class, 'vendorReplaced'])->name('replaced.products');


    // Vendor Return

    Route::get('vendor-return', [VendorReturnController::class, 'index'])->name('vendor.return.index');
    Route::get('vendor-return/approved', [VendorReturnController::class, 'approved'])->name('vendor.return.approved');
    Route::get('vendor-return/collected', [VendorReturnController::class, 'collectedReturn'])->name('vendor.return.collected');
    Route::get('vendor-return/replaced', [VendorReturnController::class, 'replaceReturn'])->name('vendor.return.replaced');
    Route::get('vendor-return/rejected', [VendorReturnController::class, 'rejectedReturn'])->name('vendor.return.rejected');

    Route::post('vendor-return/store', [VendorReturnController::class, 'store'])->name('vendor.return.store');
    Route::post('vendor-return/status/{id}', [VendorReturnController::class, 'statusUpdate'])->name('vendor.return.status.update');
    Route::post('vendor-return/collected/{id}', [VendorReturnController::class, 'collected'])->name('vendor.return.statusCollect');
    Route::post('/return/{id}/replace', [VendorReturnController::class, 'replace'])->name('vendor.return.replace');

    Route::get('replacement/history/{id}', [VendorReturnController::class, 'replacementShow'])->name('vendor.return.history.show');
    Route::get('/return/{id}/waste-receipt', [VendorReturnController::class, 'wasteReceipt'])->name('return.waste.receipt');

    Route::post('vendor-return/request/{id?}/{vendorid?}', [VendorReturnController::class, 'vendorReturnRequest'])->name('vendor.return.request.auto');

    Route::get('/return/{id}/replacement-receipt', [VendorReturnController::class, 'replacementReceipt'])->name('return.replacement.receipt');


    // Recovery
    Route::get('/recovery', [RecoveryController::class, 'index'])->name('recovery.index');


    Route::get('/quotation/send-mail/{id}', [QuotationController::class, 'sendQuotation'])
        ->name('quotation.sendMail');
    Route::post('performa/create/{id}', [QuotationController::class, 'createProforma'])->name('proforma.createFromQuotation');



    Route::get('/get-products-by-branch/{branch_id}', [ProductController::class, 'getByBranch']);
    Route::get('/get-managers/{branch_id}', [RecruitmentController::class, 'getManagers']);

    Route::get('/get-branch-data/{id}', [InvoiceController::class, 'getBranchData']);

    Route::get('/get-branch-products/{id}', [GrnController::class, 'getBranchProducts']);
    Route::get('/emailautomation/get-data', [EmailAutomationController::class, 'getData']);

    Route::get('staff/export/{department}', [StaffController::class, 'exportDepartment'])
    ->name('staff.export');

    Route::get('employee/kpi/export', [StaffController::class, 'exportKpi'])
    ->name('employee.kpi.export');

    Route::put('/purchase-order/status/{id}', [PurchaseOrderController::class, 'updateStatus'])
    ->name('purchase-order.status.update');


    // add route by Nikesh Kumar jha

    Route::resource('subscription-categories', SubscriptionCategoryController::class);
    Route::resource('service-types', ServiceTypeController::class);
    Route::resource('subscription-plans', SubscriptionPlanController::class);
    Route::resource('subscriptions', SubscriptionController::class);
    Route::resource('subscription-payments', SubscriptionPaymentController::class);
    Route::resource('renewals', RenewalController::class);

    // ajax

    // Route::get('get-service-types/{id}', [SubscriptionController::class, 'getServiceTypes']);

    Route::get('get-plans/{id}', [SubscriptionController::class, 'getPlans'])->name('get.plans');
    Route::get('get-service-types/{category_id}',[SubscriptionController::class, 'getServiceTypes'])->name('admin.get-service-types');
    Route::get('company-details/{id}', [SubscriptionController::class, 'getCompanyDetails'])->name('admin.company.details');


    // seo service route

    Route::resource('seo-services', SeoServiceController::class);
    Route::resource('seo-plans', SeoPlanController::class);
    Route::resource('seo-plan-clients', SeoPlanClientController::class);
    Route::resource('seo-team-tasks', SeoTeamTaskController::class);

    Route::get('seo-team-tasks/get-tasks/{id}', [SeoTeamTaskController::class,'getTasks'])->name('seo-team-tasks.getTasks');

    // seo team work

    Route::resource('seo-team-work', SeoTeamWorkController::class);
    Route::post('seo-team-work/{item}/complete',[App\Http\Controllers\Admin\SeoTeamWorkController::class, 'complete'])->name('seo-team-work.complete');
    Route::post('/seo-team-works/store', [SeoTeamWorkController::class, 'store'])->name('admin.seo-team-works.store');
    Route::get('/seo/distribution/{id}', [SeoReportController::class, 'distribution'])->name('seo.task.distribution');
    Route::post('/seo/distribution/{id}', [SeoReportController::class, 'distributionStore'])->name('seo.task.distribution.store');

    // filter

    Route::get('/seo-report', [SeoReportController::class, 'index'])->name('seo-report.index');
    Route::get('/seo-report/dashboard', [SeoReportController::class, 'dashboard'])->name('seo-report.index.dashboard');
    Route::post('/generate', [SeoReportController::class, 'generate'])->name('seo-report.generate');
    Route::get('vendor/seo/reports', [SeoReportController::class,'reports'])->name('vendor.seo.reports');
    Route::get('vendor/report/{planClient}/{date}', [SeoReportController::class,'reportDetail'])->name('vendor.seo.report.show');
    Route::get('seo/reports/{planClient}', [SeoReportController::class, 'adminReports'])->name('seo.reports');

    // daily updates

    Route::put('backlink-assignment/{id}/complete', [BacklinkAssignmentController::class, 'complete'])->name('backlink-assignment.complete');
    Route::put('backlink-assignment/{id}/inline-update', [BacklinkAssignmentController::class, 'inlineUpdate'])->name('backlink-assignment.inline-update');
    
    Route::resource('daily-update-task', DailyUpdateTaskController::class);
    Route::get('daily-update-task-today', [DailyUpdateTaskController::class,'today'])->name('daily-update-task.today');

    
    // project

    Route::resource('projects', ProjectController::class);
    Route::get('projects/get-lead/{lead}', [ProjectController::class,'getLead'])->name('projects.getLead');
    Route::get('projects/get-developers/{department}', [ProjectController::class, 'getDevelopers'])->name('projects.getDevelopers');
    Route::get('projects/{project}/workspace', [ProjectController::class, 'workspace'])->name('admin.projects.workspace');


    // Route::resource('project-modules', ProjectModuleController::class);

    Route::get('projects/{project}/modules/create', [ProjectModuleController::class, 'create'])->name('projects.modules.create');
    Route::post('projects/modules/store', [ProjectModuleController::class, 'store'])->name('projects.modules.store');
    Route::get('modules', [ProjectModuleController::class, 'assingmodule'])->name('modules.index');
    Route::get('modules/{module}', [ProjectModuleController::class, 'show'])->name('modules.show');

    // 

    Route::get('requests', [ProjectModuleController::class, 'requests'])->name('modules.requests');
    Route::post('modules/requests/{assignment}/accept', [ProjectModuleController::class, 'accept'])->name('modules.requests.accept');
    Route::post('modules/requests/{assignment}/reject', [ProjectModuleController::class, 'reject'])->name('modules.requests.reject');
    Route::patch('project-submodules/{subModule}/status', [ProjectSubModuleController::class, 'updateStatus'])->name('project-submodules.status');


    //    project lead developer or user chat

    Route::get('projects/{project}/chat', [ProjectMessageController::class, 'index'])->name('projects.chat');
    Route::post('projects/{project}/chat', [ProjectMessageController::class, 'store'])->name('projects.chat.store');

    Route::resource('backlink-categories', BacklinkCategoryController::class);
    Route::resource('backlinks', BacklinkController::class);

    Route::get('backlinks-upload', [BacklinkController::class, 'upload'])->name('backlinks.upload');
    Route::post('backlinks-import', [BacklinkController::class, 'import'])->name('backlinks.import');

    Route::resource('on-page-seo-category', OnPageSeoCategoryController::class)->names('on-page-seo-category');
    Route::resource('onpage-seo-task', OnPageSeoTaskController::class)->names('onpage-seo-task');

    
    Route::post('on-page-seo/update', [OnPageSeoController::class, 'update'])->name('on-page-seo.update');
    Route::post('on-page-seo/update', [OnPageSeoController::class, 'update'])->name('on-page-seo.update');

    Route::get('backlink-assignment/{id}', [BacklinkAssignmentController::class, 'index'])->name('admin.backlink-assignment.index');
    Route::post('backlink-assignment/{id}/quick-assign', [BacklinkAssignmentController::class, 'quickAssign'])->name('backlink-assignment.quick-assign');
    Route::put('backlink-assignment/{id}/inline-update', [BacklinkAssignmentController::class, 'inlineUpdate'])->name('backlink-assignment.inline-update');
   
   
        

    
});

// Route::put('backlink-assignment/{id}/complete', [BacklinkAssignmentController::class, 'complete'])->name('backlink-assignment.complete');

Route::prefix('admin/backlink-assignment')->name('admin.backlink-assignment.')->group(function () {
    Route::get('/{id}', [BacklinkAssignmentController::class, 'index'])->name('index');
    Route::post('/store', [BacklinkAssignmentController::class, 'store'])->name('store');
});


Route::get('/seo-team-work/{seoTeamTask}', [SeoTeamWorkController::class,'show'])->name('admin.seo-team-work.show');


Route::prefix('modules/{module}/submodules')->name('submodules.')->group(function () {
    Route::get('/submodules', [ProjectSubModuleController::class, 'index'])->name('submodules.index');
    Route::get('/create', [ProjectSubModuleController::class,'create'])->name('create');
    Route::post('/', [ProjectSubModuleController::class,'store'])->name('store');
    Route::get('/{submodule}/edit', [ProjectSubModuleController::class,'edit'])->name('edit');
    Route::put('/{submodule}', [ProjectSubModuleController::class,'update'])->name('update');
    Route::delete('/{submodule}', [ProjectSubModuleController::class,'destroy'])->name('destroy');
});


Route::middleware(['auth','role:End Customer'])->prefix('user')->name('user.')->group(function () {
    Route::get('/my-projects', [UserProjectController::class,'index'])->name('projects.index');
    Route::get('/my-projects/{project}', [UserProjectController::class,'show'])->name('projects.show');
});



 



Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('on-page-seo/{project}', [OnPageSeoController::class, 'index'])->name('on-page-seo.index');
    Route::post('on-page-seo/update-task', [OnPageSeoController::class, 'updateTask'])->name('on-page-seo.update-task');
});

   
Route::get('seo-project/{seoPlanClient}/keywords', [SeoProjectKeywordController::class, 'index'])->name('seo-project-keywords.index'); 
Route::post('seo-project/{seoPlanClient}/keywords', [SeoProjectKeywordController::class, 'saveAll'])->name('seo-project-keywords.save');
Route::get('/seo-dashboard/{planClient}', [SeoReportController::class, 'clientreportdashboard'])->name('seo.dashboard');


Route::prefix('projects')->group(function () {
    Route::get('{project}/modules/workspace', [ProjectModuleController::class, 'index'])->name('projects.modules.workspace');
});



Route::post('/developer/modules/{assignment}/reassign', [ProjectModuleController::class,'reassign'])->name('developer.modules.reassign');





//

// List + raise requirements for a specific module
Route::prefix('modules/{module}/requirements')->name('admin.requirements.')->group(function () {
    Route::get('/', [RequirementController::class, 'index'])->name('index');
    Route::post('/', [RequirementController::class, 'store'])->name('store');
});

// Actions on a single requirement
Route::prefix('requirements/{requirement}')->name('admin.requirements.')->group(function () {
    Route::get('/', [RequirementController::class, 'show'])->name('show');
    Route::post('seen', [RequirementController::class, 'markSeen'])->name('seen');
    Route::post('forward-admin', [RequirementController::class, 'forwardAdmin'])->name('forward-admin');
    Route::post('forward-client', [RequirementController::class, 'forwardClient'])->name('forward-client');
    Route::post('complete', [RequirementController::class, 'complete'])->name('complete');
    Route::post('reject', [RequirementController::class, 'reject'])->name('reject');

    Route::post('comments', [RequirementCommentController::class, 'store'])->name('comments.store');
    Route::post('upload', [RequirementAttachmentController::class, 'store'])->name('upload');
});

// Standalone comment/attachment deletes
Route::delete('requirement-comments/{comment}', [RequirementCommentController::class, 'destroy'])
    ->name('admin.requirements.comments.destroy');

Route::delete('requirement-attachments/{attachment}', [RequirementAttachmentController::class, 'destroy'])
    ->name('admin.requirements.attachments.destroy');
    








Route::middleware(['auth'])->group(function () {

    // Lead Developer / Admin submits Approve or Request Changes.
    Route::post(
        '/admin/project-submodules/{submodule}/review',
        [SubModuleReviewController::class, 'store']
    )->name('admin.project-submodules.review.store');

    // Read-only review history for a single submodule.
    Route::get(
        '/admin/project-submodules/{submodule}/review-history',
        [SubModuleReviewController::class, 'history']
    )->name('admin.project-submodules.review.history');

    Route::get(
        '/admin/submodules/all',
        [ProjectSubModuleController::class, 'allSubmodules']
    )->name('admin.submodules.all');


    // 

   
    Route::post(
        '/leads/quick-proforma/store',
        [LeadController::class, 'storeQuickProforma']
    )->name('leads.quick-proforma.store');

    Route::post(
        '/update-quotation-stage/{id}',
        [LeadController::class, 'updateQuotationStage']
    )->name('update-quotation-stage');

    Route::post(
        '/update-proforma-stage/{id}',
        [LeadController::class, 'updateProformaStage']
    )->name('update-proforma-stage');

    // 



   

});

Route::get('developer/modules', [ProjectModuleController::class, 'allmodules'])->name('developer.all.modules.index');



Route::get('/shared/detailed-quotation/{quotation}', [DetailedQuotationController::class, 'publicShare'])->middleware('signed')->name('detailed-quotations.public-share');

