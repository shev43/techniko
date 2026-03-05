<div class="column-access-panel">
    <div class="columns-panel-item-group nav inline gap-2 mt-4 justify-content-center nav-pills" id="h-access-right-tab" role="tablist" aria-orientation="horizontal">
        <a class="columns-panel-item columns-panel-item-link active" id="h-access-right-business-tab" data-bs-toggle="pill" data-bs-target="#h-access-right-business" role="tab" aria-controls="h-access-right-business" aria-selected="false" style="cursor: pointer">
            <div class="d-flex align-items-center">
                <span class="ms-3">Орендодавці</span>
            </div>
        </a>
        <a class="columns-panel-item columns-panel-item-link" id="h-access-right-clients-tab" data-bs-toggle="pill" data-bs-target="#h-access-right-clients" role="tab" aria-controls="h-access-right-clients" aria-selected="true" style="cursor: pointer">
            <div class="d-flex align-items-center">
                <span class="ms-3">Клієнти</span>
            </div>
        </a>
        <a class="columns-panel-item columns-panel-item-link" id="h-access-right-orders-tab" data-bs-toggle="pill" data-bs-target="#h-access-right-orders" role="tab" aria-controls="h-access-right-orders" aria-selected="true" style="cursor: pointer">
            <div class="d-flex align-items-center">
                <span class="ms-3">Замовлення</span>
            </div>
        </a>
        <a class="columns-panel-item columns-panel-item-link" id="h-access-right-subscription-tab" data-bs-toggle="pill" data-bs-target="#h-access-right-subscription" role="tab" aria-controls="h-access-right-subscription" aria-selected="true" style="cursor: pointer">
            <div class="d-flex align-items-center">
                <span class="ms-3">Підписки</span>
            </div>
        </a>
        <a class="columns-panel-item columns-panel-item-link" id="h-access-right-reports-tab" data-bs-toggle="pill" data-bs-target="#h-access-right-reports" role="tab" aria-controls="h-access-right-reports" aria-selected="true" style="cursor: pointer">
            <div class="d-flex align-items-center">
                <span class="ms-3">Статистика</span>
            </div>
        </a>
        <a class="columns-panel-item columns-panel-item-link" id="h-access-right-users-tab" data-bs-toggle="pill" data-bs-target="#h-access-right-users" role="tab" aria-controls="h-access-right-users" aria-selected="true" style="cursor: pointer">
            <div class="d-flex align-items-center">
                <span class="ms-3">Адміністратори</span>
            </div>
        </a>
        <a class="columns-panel-item columns-panel-item-link" id="h-access-right-mailing-tab" data-bs-toggle="pill" data-bs-target="#h-access-right-mailing" role="tab" aria-controls="h-access-right-mailing" aria-selected="true" style="cursor: pointer">
            <div class="d-flex align-items-center">
                <span class="ms-3">Розсилання</span>
            </div>
        </a>
        <a class="columns-panel-item columns-panel-item-link" id="h-access-right-settings-tab" data-bs-toggle="pill" data-bs-target="#h-access-right-settings" role="tab" aria-controls="h-access-right-settings" aria-selected="true" style="cursor: pointer">
            <div class="d-flex align-items-center">
                <span class="ms-3">Модерація</span>
            </div>
        </a>
    </div>
</div>

<div class="mt-5">
    <div class="tab-content" id="h-access-right-tabContent">
        <div class="tab-pane fade show active" id="h-access-right-business" role="tabpanel" aria-labelledby="h-access-right-business-tab">
            <div class="mb-4">
                <h5 class="mb-3">Орендодавці</h5>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-eye feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Перегляд</div>
                            </div>
                        </div>
                        <div class="ms-3">

                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="business_switch_view" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['business.index']) && $current_role['business.index'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-plus feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Створення нової записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="business_switch_add" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['business.create']) && $current_role['business.create'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-trash feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Видалення записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="business_switch_delete" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['business.destroy']) && $current_role['business.destroy'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-trash feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Імпорт даних</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="business_import_switch_view" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['business.import']) && $current_role['business.import'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="mb-4">
                <h5 class="mt-5 mb-3">Профіль</h5>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-eye feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Перегляд</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="business_profile_switch_view" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['business.profile.index']) && $current_role['business.profile.index'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-edit feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Редагування записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="business_profile_switch_edit" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['business.profile.edit']) && $current_role['business.profile.edit'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <h5 class="mt-5 mb-3">Представник</h5>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-edit feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Редагування записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="business_company_switch_edit" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['business.company.edit']) && $current_role['business.company.edit'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h5 class="mb-3">Контакти</h5>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-eye feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Перегляд</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="business_contacts_switch_view" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['business.contacts.index']) && $current_role['business.contacts.index'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-plus feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Створення нової записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="business_contacts_switch_add" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['business.contacts.create']) && $current_role['business.contacts.create'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-edit feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Редагування записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="business_contacts_switch_edit" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['business.contacts.edit']) && $current_role['business.contacts.edit'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-trash feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Видалення записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="business_contacts_switch_delete" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['business.contacts.destroy']) && $current_role['business.contacts.destroy'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h5 class="mb-3">Преміум підписки</h5>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-eye feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Перегляд</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="business_subscription_switch_view" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['business.subscription.index']) && $current_role['business.subscription.index'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="tab-pane fade" id="h-access-right-clients" role="tabpanel" aria-labelledby="h-access-right-clients-tab">
            <div class="mb-4">
                <h5 class="mb-3">Клієнти</h5>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-eye feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Перегляд</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="clients_switch_view" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['clients.index']) && $current_role['clients.index'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-plus feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Створення нової записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="clients_switch_add" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['clients.create']) && $current_role['clients.create'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-edit feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Редагування записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="clients_switch_edit" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['clients.edit']) && $current_role['clients.edit'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-trash feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Видалення записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="clients_switch_delete" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['clients.destroy']) && $current_role['clients.destroy'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="h-access-right-orders" role="tabpanel" aria-labelledby="h-access-right-orders-tab">
            <div class="mb-4">
                <h5 class="mb-3">Замовлення</h5>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-eye feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Перегляд</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="orders_switch_view" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['orders.index']) && $current_role['orders.index'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-edit feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Редагування записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="orders_switch_edit" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['orders.edit']) && $current_role['orders.edit'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="h-access-right-subscription" role="tabpanel" aria-labelledby="h-access-right-subscription-tab">
            <div class="mb-4">
                <h5 class="mb-3">Підписки</h5>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-eye feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Перегляд</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="subscription_switch_view" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['subscription.index']) && $current_role['subscription.index'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="h-access-right-reports" role="tabpanel" aria-labelledby="h-access-right-reports-tab">
            <div class="mb-4">
                <h5 class="mb-3">Статистика</h5>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-eye feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Перегляд</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="reports_switch_view" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['reports.index']) && $current_role['reports.index'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="h-access-right-users" role="tabpanel" aria-labelledby="h-access-right-users-tab">
            <div class="mb-4">
                <h5 class="mb-3">Адміністратори</h5>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-eye feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Перегляд</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="users_switch_view" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['users.index']) && $current_role['users.index'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-plus feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Створення нової записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="users_switch_add" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['users.create']) && $current_role['users.create'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-edit feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Редагування записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="users_switch_edit" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['users.edit']) && $current_role['users.edit'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-trash feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Видалення записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="users_switch_delete" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['users.destroy']) && $current_role['users.destroy'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="h-access-right-mailing" role="tabpanel" aria-labelledby="h-access-right-mailing-tab">
            <div class="mb-4">
                <h5 class="mb-3">Розсилання</h5>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-eye feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Перегляд</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="mailing_switch_view" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['mailing.index']) && $current_role['mailing.index'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="h-access-right-settings" role="tabpanel" aria-labelledby="h-access-right-settings-tab">
            <div class="mb-4">
                <h5 class="mb-3">Види техніки</h5>
{{--                <div class="p-3 border-bottom">--}}
{{--                    <div class="d-flex align-items-center justify-content-between">--}}
{{--                        <div class="d-flex align-items-md-center">--}}
{{--                            <i class="icon-eye feather h2 text-primary mb-0 "></i>--}}
{{--                            <div class="ms-3">--}}
{{--                                <div class="text-dark fw-bolder">Перегляд</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="ms-3">--}}
{{--                            <div class="form-check form-switch">--}}
{{--                                <label role="checkbox" class="form-check-label">--}}
{{--                                    <input type="checkbox" role="switch" class="form-check-input" name="settings_technics_switch_view" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['settings.machines.index']) && $current_role['settings.machines.index'] == 1) ? 'checked' : '') }}>--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-plus feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Створення нової записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="settings_technics_switch_add" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['settings.machines.create']) && $current_role['settings.machines.create'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-edit feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Редагування записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="settings_technics_switch_edit" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['settings.machines.edit']) && $current_role['settings.machines.edit'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-trash feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Видалення записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="settings_technics_switch_delete" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['settings.machines.destroy']) && $current_role['settings.machines.destroy'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <h5 class="mb-3">Категорії технік</h5>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-eye feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Перегляд</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="settings_technics_category_switch_view" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['settings.machine-categories.index']) && $current_role['settings.machine-categories.index'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-plus feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Створення нової записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="settings_technics_category_switch_add" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['settings.machine-categories.create']) && $current_role['settings.machine-categories.create'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-edit feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Редагування записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="settings_technics_category_switch_edit" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['settings.machine-categories.edit']) && $current_role['settings.machine-categories.edit'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-md-center">
                            <i class="icon-trash feather h2 text-primary mb-0 "></i>
                            <div class="ms-3">
                                <div class="text-dark fw-bolder">Видалення записи</div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="form-check form-switch">
                                <label role="checkbox" class="form-check-label">
                                    <input type="checkbox" role="switch" class="form-check-input" name="settings_technics_category_switch_delete" value="1" {{ ($mode == 'add') ? 'checked' : ((!empty($current_role['settings.machine-categories.destroy']) && $current_role['settings.machine-categories.destroy'] == 1) ? 'checked' : '') }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
