<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

/**
 * This is controller for CRON job for import
 */
class ElegantalEasyImportImportModuleFrontController extends ModuleFrontController
{
    /** @var ElegantalEasyImport */
    public $module;

    public function display()
    {
        $this->module->initModel(Tools::getValue('id'));
        $model = $this->module->model;

        $secure_key = $this->module->getSetting('security_token_key');
        if (!$secure_key || Tools::getValue('secure_key') != $secure_key) {
            die('Access Denied.');
        } elseif (!$model || !$model->id) {
            die('Object not found.');
        } elseif (!$model->active) {
            die('Import rule is not active.');
        } elseif (!$model->is_cron) {
            die('Import rule is not enabled for CRON.');
        }

        try {
            $remaining_rows = ElegantalEasyImportData::model()->countAll(array(
                'condition' => array(
                    'id_elegantaleasyimport' => $model->id,
                ),
            ));

            $file = ElegantalEasyImportTools::getRealPath($model->csv_file);
            $limit = ($model->product_limit_per_request > 0 && $model->product_limit_per_request <= 1000000) ? (int) $model->product_limit_per_request : 50;

            if (!$file || !is_file($file) || !filesize($file)) {
                // File does not exist, download and start import
                $model->downloadImportFile();
                $model->saveCsvRows();
                $model->import($limit);
            } elseif (empty($remaining_rows)) {
                $old_md5 = $model->cron_csv_file_md5;
                $old_size = $model->cron_csv_file_size;

                $model->downloadImportFile();

                $new_md5 = $model->cron_csv_file_md5;
                $new_size = $model->cron_csv_file_size;

                $is_auto_restart = false;
                $rule_ids_for_auto_restart = $this->module->getSetting('rule_ids_for_auto_restart_cron_import');
                if ($rule_ids_for_auto_restart) {
                    $rule_ids_for_auto_restart = explode(",", $rule_ids_for_auto_restart);
                    $rule_ids_for_auto_restart = array_map("intval", $rule_ids_for_auto_restart);
                    if (in_array($model->id, $rule_ids_for_auto_restart)) {
                        $is_auto_restart = true;
                    }
                }

                // If file is different, start import
                if ($old_size != $new_size || $old_md5 != $new_md5 || $is_auto_restart) {
                    $model->saveCsvRows();
                    $model->import($limit);
                }
            } elseif ($remaining_rows > 0) {
                $model->import($limit);
            }
        } catch (Exception $e) {
            $model->addError('CRON: ' . $e->getMessage());
            if ($this->module->getSetting('is_debug_mode')) {
                die($e->getMessage());
            }
        }
        die('CRON executed successfully.');
    }
}
