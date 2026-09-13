<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

use function PHPSTORM_META\map;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            //    'role-list',
            //    'role-create',
            //    'role-edit',
            //    'role-delete'
            //    'view-receivable',

            // 'view-purchase-requisition',
            // 'convert-purchase-requisition',

            // 'convert-purchase-order',
            // 'view-purchase-order',

            // 'view-support-tickets',
            // 'create-support-ticket',
            // 'view-support-ticket',
            // 'reply-support-ticket',
            // 'fetch-support-messages',

            // 'support-department-list',
            // 'support-department-create',
            // 'support-department-update',
            // 'support-department-delete',

            // 'grn-list',
            // 'grn-create',
            // 'grn-delete',
            // 'grn-show',
            // 'grn-update',

            // 'production-consumption-list',
            // 'production-consumption-create',
            // 'production-consumption-update',
            // 'production-consumption-delete'

            // 'production-order-list',
            // 'production-order-create',
            // 'production-order-update',
            // 'production-order-delete',
            // 'production-order-show'

            // 'bom-list',
            // 'bom-create',
            // 'bom-update',
            // 'bom-delete',
            // 'bom-show'

            // 'stockmovement-list',
            // 'stockmovement-create',
            // 'stockmovement-edit',
            // 'stockmovement-delete',
            // 'stockmovement-show',

            // 'warehouse-list',
            // 'warehouse-create',
            // 'warehouse-update',
            // 'warehouse-delete',

            // 'product-list',
            // 'product-create',
            // 'product-update',
            // 'product-delete'

            // 'product-category-list',
            // 'product-category-create',
            // 'product-category-update',
            // 'product-category-delete'

            // 'vendor-contract-list',
            // 'vendor-contract-create',
            // 'vendor-contract-update',
            // 'vendor-contract-delete'

            // 'vendor-list',
            // 'vendor-create',
            // 'vendor-update',
            // 'vendor-delete'
            // 'vendor-rate'

            // 'tax-list',
            // 'tax-create',
            // 'tax-update',
            // 'tax-delete'

            // 'organization-list',
            // 'organization-create',
            // 'organization-update',
            // 'organization-delete'

            // 'invoice-list',
            // 'invoice-create',
            // 'invoice-update',
            // 'invoice-delete',
            // 'invoice-show'

            // 'lead-category-list',
            // 'lead-category-create',
            // 'lead-category-update',
            // 'lead-category-delete'

            // 'lead-list',
            // 'lead-create',
            // 'lead-update',
            // 'lead-delete'

            // 'deal-list',
            // 'deal-create',
            // 'deal-update'

            // 'email-template-list',
            // 'email-template-create',
            // 'email-template-update',
            // 'email-template-delete'

            // 'subscriber-list',
            // 'subscriber-create',
            // 'subscriber-update',
            // 'subscriber-delete'

            // 'email-automation-list',
            // 'email-automation-create',
            // 'email-automation-update',
            // 'email-automation-delete'

            // 'recuritment-list',
            // 'recuritment-create',
            // 'recuritment-update',
            // 'recuritment-show',
            // 'recuritment-delete'

            // 'candidate-list',
            // 'candidate-create',
            // 'candidate-update',
            // 'candidate-delete',
            // 'candidate-show'

            // 'stage-list',
            // 'stage-create',

            // 'designation-list',
            // 'designation-create',
            // 'designation-update',
            // 'designation-delete'

            // 'department-list',
            // 'department-create',
            // 'department-update',
            // 'department-delete'

            // 'policy-list',
            // 'policy-create',
            // 'policy-update',
            // 'policy-delete'
            // 'policy-show'

            // 'hsn-list',
            // 'hsn-create',
            // // 'branch-edit',
            // 'hsn-delete'

            // 'kpi-list',
            // 'kpi-create',
            // 'kpi-edit',
            // 'kpi-delete'


            // 'payment-terms-list',
            // 'payment-terms-create',
            // 'payment-terms-edit',
            // 'payment-terms-delete'

            // 'performa-list',
            // 'performa-create',
            // 'performa-show'

            // 'purchase-bill-list',
            // 'purchase-bill-show',
            // 'purchase-bill-pay'

            // 'purchase-order-list',
            // 'purchase-order-show',

            // 'purchase-requisition-list',
            // 'purchase-requisition-show',

            // 'sales-order-list',
            // 'sales-order-show'

            // 'payable-list',
            // 'payable-create',
            // 'payable-show',
            // 'kra-delete'
            // 'convert-sales-order-from-proforma',

            // 'view-sales-orders',
            // 'create-sales-order',

            // 'generate-invoice-from-sales-order',

            // 'view-delivery',
            // 'mark-ready-to-delivery',

            // 'view-dispatch',
            // 'view-dispatch-form',
            // 'submit-dispatch',

            // 'sold-product-list',
            // 'sold-product-create',
            // 'sold-product-show'

            // 'manufacturing-start',

            // 'packing-list',
            // 'delivery-list',
            // 'disptach-invoice-list',
            // 'dispatch-list'

            // 'holiday-list',
            // 'holiday-create',
            // 'holiday-update',
            // 'holiday-delete'

            // 'leave-type-list',
            // 'leave-type-create',
            // 'leave-type-update',
            // 'leave-type-delete'

            // 'attendence'

            // 'suspense-entry-list',
            // 'suspense-entry-create'

            // 'support-tickets'

            // 'leave-report-list',
            // 'leave-report-store',
            // 'leave-report-edit',
            // 'leave-report-delete'


            // 'vendor-return-list',
            // 'vendor-return-create',
            // 'vendor-return-edit',
            // 'vendor-return-delete'

            // 'warranty-list',
            // 'warranty-create',
            // 'warranty-show',
            // 'warranty-edit',

            // ====================== PROJECT ======================

            // 'project-view',
            // 'project-create',
            // 'project-edit',
            // 'project-delete',

            // 'project-list',
            // 'project-show',

            // ====================== MODULE ======================

            // 'module-view',
            // 'module-create',
            // 'module-edit',
            // 'module-delete',
            // 'module-assign',
            // 'module-accept',
            // 'module-reject',

            // 'module-requested'


            // ====================== SUB MODULE ======================

            // 'submodule-view',
            // 'submodule-create',
            // 'submodule-edit',
            // 'submodule-delete',
            // 'submodule-update_status',

            // ====================== ATTACHMENTS ======================

            // 'project-attachment-upload',
            // 'project-attachment-delete',

            // 'project-my-project',
            // 'project-chat',

            // SEO Services
            // 'seo-service-list',
            // 'seo-service-create',
            // 'seo-service-edit',
            // 'seo-service-delete',
            // 'seo-service-view',

            // SEO Plans
            // 'seo-plan-list',
            // 'seo-plan-create',
            // 'seo-plan-edit',
            // 'seo-plan-delete',
            // 'seo-plan-view',

            // SEO Assign Clients
            // 'seo-assign-client-list',
            // 'seo-assign-client-create',
            // 'seo-assign-client-edit',
            // 'seo-assign-client-delete',
            // 'seo-assign-client-view',

            // SEO Team Task
            // 'seo-team-task-list',
            // 'seo-team-task-create',
            // 'seo-team-task-edit',
            // 'seo-team-task-delete',
            // 'seo-team-task-view',
            // 'seo-team-task-assign',
            // 'seo-team-task-status',
            // 'seo-team-task-complete',
            // 'seo-reports',

            // 'backlink-categories-list',
            // 'backlink-categories-create',
            // 'backlink-categories-edit',

            // 'backlink-categories-delete',

            // 'backlink-list',
            // 'backlink-create',
            // 'backlink-bulk-upload',
            // 'backlink-edit',

            // 'backlink-assign',

            // 'backlink-delete',

            // 'on-page-categories-list',
            // 'on-page-categories-create',
            // 'on-page-categories-edit',

            // 'on-page-categories-delete',

            // 'on-page-seo-tasks-list',
            // 'on-page-seo-tasks-create',
            // 'on-page-seo-tasks-edit',
            // 'on-page-seo-tasks-delete',

            
            'leads-import-upload-history'


        ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
