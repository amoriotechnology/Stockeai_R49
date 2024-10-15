<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!function_exists('display')) {
    function display($text = null) {
        $ci = & get_instance();
        $ci->load->database();
        $table = 'language';
        $phrase = 'phrase';
        $setting_table = 'web_setting';
        $default_lang = 'english';
        //set language  
        $data = $ci->db->get($setting_table)->row();
 
        if (!empty($data->language)) {
            $language = $data->language;
        } else {
            $language = $default_lang;
        }
        if (!empty($text)) {
            if ($ci->db->table_exists($table)) {
                if ($ci->db->field_exists($phrase, $table)) {
                    if ($ci->db->field_exists($language, $table)) {
                        $row = $ci->db->select($language)
                                ->from($table)
                                ->where($phrase, $text)
                                ->get()
                                ->row();
                        if (!empty($row->$language)) {
                            return html_escape($row->$language);
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
if (!function_exists('encrypt')) {
    function encrypt($data, $key) {
        $method = 'AES-256-CBC';
        $key = substr(hash('sha256', $key, true), 0, 32);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
        $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);
        return $iv . $encrypted;
    }
}
if (!function_exists('decrypt')) {
function decrypt($data, $key) {
    $method = 'AES-256-CBC';
    $key = substr(hash('sha256', $key, true), 0, 32);
    $iv_length = openssl_cipher_iv_length($method);
    $iv = substr($data, 0, $iv_length);
    $encrypted = substr($data, $iv_length);
    return openssl_decrypt($encrypted, $method, $key, 0, $iv);
}
}


if (!function_exists('decodeBase64UrlParameter')) {
    function decodeBase64UrlParameter($urlParam) {
        $text = hex2bin($urlParam);
        return decrypt($text,COMPANY_ENCRYPT_KEY);
    }
}

if (!function_exists('encodeBase64UrlParameter')) {
    function encodeBase64UrlParameter($urlParam) {
        $encres = encrypt($urlParam, COMPANY_ENCRYPT_KEY);
        return bin2hex($encres);
    }
}
if (!function_exists('alpha_space')) {
    function alpha_space($str) {
        return (bool) preg_match('/^[a-zA-Z ]+$/', $str);
    }
}

if (!function_exists('getAllCountries')) {
    function getAllCountries() {
        $ci = & get_instance();
        $ci->load->database();
        $res = $ci->db->select('iso,name,nickname,iso3,numcode,phonecode')
                      ->from('country')
                      ->order_by('iso')
                      ->get()
                      ->result_array();
        return $res;
    }
}
if (!function_exists('getAllCurrencies')) {
    function getAllCurrencies() {
        $ci = & get_instance();
        $ci->load->database();
        $res = $ci->db->select('code,description,symbol')
                      ->from('currency')
                      ->order_by('code')
                      ->get()
                      ->result_array();
        return $res;
    }
}

if (!function_exists('getAllStates')) {
    function getAllStates() {
        $ci = & get_instance();
        $ci->load->database();
        $res = $ci->db->select('id,state_name')
                      ->from('states')
                      ->order_by('state_name')
                      ->get()
                      ->result_array();
        return $res;
    }
}

if (!function_exists('getAllBanks')) {
    function getAllBanks() {
        $ci = & get_instance();
        $ci->load->database();
        $res = $ci->db->select('bank_id,bank_name')
                      ->from('bank_add')
                      ->order_by('bank_name')
                      ->get()
                      ->result_array();
        return $res;
    }
}

// Single Attachments

if (!function_exists('file_upload')) {
    function file_upload($file,$filename,$filepath)
    {
        $CI =& get_instance();
        $CI->load->library('upload');

        $config['upload_path'] = $filepath; 
        $config['allowed_types'] = IMAGE_ALLOWED_TYPES;
        $new_filename = $filename.'_'.time();
        $config['file_name'] = $new_filename;
        $CI->upload->initialize($config);

        if (!$CI->upload->do_upload($file)) {
            $error = array('error' => $CI->upload->display_errors());
            return $error;
        } else {
            $data = array('upload_data' => $CI->upload->data());
            return $data;
        }
    }
}

if (!function_exists('multiple_file_upload')) {
    function multiple_file_upload($file,$index, $filename,$filepath)
       {
           $CI =& get_instance();
           $CI->load->library('upload');
           $_FILES['file']['name'] = $_FILES[$file]['name'][$index];
           $_FILES['file']['type'] = $_FILES[$file]['type'][$index];
           $_FILES['file']['tmp_name'] = $_FILES[$file]['tmp_name'][$index];
          // $_FILES['file']['error'] = $_FILES[$file]['error'][$index];
           //$_FILES['file']['size'] = $_FILES[$file]['size'][$index];

          
           $config['max_size'] = '5000'; // max_size in kb

           $config['upload_path'] = $filepath; 
           $config['allowed_types'] = IMAGE_ALLOWED_TYPES;
           $new_filename = $filename.'_'.time();
           $config['file_name'] = $new_filename;
           $CI->upload->initialize($config);
   
           if (!$CI->upload->do_upload('file')) {
               $error = array('error' => $CI->upload->display_errors());
               return $error;
           } else {
               $data = array('upload_data' => $CI->upload->data());
               return $data;
           }
       }
   }
if (!function_exists('checkFileType')) {
    function checkFileType($filename) {
        $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $pdfExtension = 'pdf';

        if (in_array($fileExtension, $imageExtensions)) {
            return 'image';
        }

        if ($fileExtension === $pdfExtension) {
            return 'pdf';
        }

        return 'unknown';
    }
}

function getDataInsideBrackets($string) {
   $pattern = '/\(([^)]+)\)/';

    if (preg_match($pattern, $string, $matches)) {
        return $matches[1];
    }
    return null;
}

// Common funtion in Attachments
if (!function_exists('insertAttachments')) {
    function insertAttachments($id, $filename,$filepath,$module_name,$admin_id,$created_by) {
        $ci = & get_instance();
        $ci->load->database();
        $data = array(
            'attachment_id' => $id,
            'files'         => $filename,
            'image_dir'     => $filepath,
            'sub_menu'      => $module_name,
            'created_admin' => $admin_id,
            'created_by'    => $created_by
        );


        $res = $ci->db->insert('attachments',$data);
        
         

        return $ci->db->insert_id;
    }
}



