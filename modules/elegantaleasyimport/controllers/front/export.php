<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

/**
 * This is controller for CRON job for export
 */
class ElegantalEasyImportExportModuleFrontController extends ModuleFrontController
{
    /** @var ElegantalEasyImport */
    public $module;

    public function display()
    {
        $secure_key = $this->module->getSetting('security_token_key');
        $model = new ElegantalEasyImportExport(Tools::getValue('id'));

        if (!$secure_key || Tools::getValue('secure_key') != $secure_key) {
            die('Access Denied.');
        } elseif (!$model || !$model->id) {
            die('Object not found.');
        } elseif (!$model->active) {
            die('Export rule is not active.');
        }

        if (Tools::getValue('action') == 'download') {
            return $this->downloadExportFile($model);
        }

        $date_started = date('d-m-Y H:i:s');

        $result = $model->export();

        if (isset($result['success']) && $result['success']) {
            $message = isset($result['count']) ? $result['count'] . ' ' : '';
            $message .= ($model->entity == 'combination') ? 'combinations exported successfully.' : 'products exported successfully.';
            // Send notification
            if ($model->email_to_send_notification && Validate::isEmail($model->email_to_send_notification)) {
                try {
                    $subject = 'CRON has finished exporting for the rule "' . $model->name . '"';
                    $template_vars = array(
                        '{rule_name}' => $model->name,
                        '{date_started}' => $date_started,
                        '{date_ended}' => date('d-m-Y H:i:s'),
                        '{message}' => $message,
                        '{download_link}' => $this->module->getControllerUrl('export', array('action' => 'download', 'id' => $model->id)),
                    );
                    $template_path = dirname(__FILE__) . '/mails/';
                    Mail::Send($this->context->language->id, 'export_finished', $subject, $template_vars, $model->email_to_send_notification, null, null, "Easy Import Module", null, null, $template_path);
                } catch (Exception $e) {
                    // Do nothing
                }
            }
            die($message);
        } elseif (isset($result['message'])) {
            die($result['message']);
        }
        exit;
    }

    private function downloadExportFile($model)
    {
        if (!is_file($model->file_path)) {
            die('File not found.');
        }
        $mime = 'application/octet-stream';
        switch ($model->file_format) {
            case 'csv':
                $mime = 'text/csv';
                break;
            case 'xml':
                $mime = 'text/xml';
                break;
            case 'json':
                $mime = 'application/json';
                break;
            case 'xls':
                $mime = 'application/vnd.ms-excel';
                break;
            case 'xlsx':
                $mime = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                break;
            case 'ods':
                $mime = 'application/vnd.oasis.opendocument.spreadsheet';
                break;
            case 'txt':
                $mime = 'text/plain';
                break;
            default:
                break;
        }
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . basename($model->file_path) . '"');
        header('Content-Length: ' . filesize($model->file_path));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Expires: 0');
        while (ob_get_level()) {
            ob_end_clean();
        }
        readfile($model->file_path);
        exit;
    }
}
