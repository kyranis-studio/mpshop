<?php
/**
 * 2007-2021 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 web site only.
 * If you want to use this file on more web sites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 * @author ETS-Soft <etssoft.jsc@gmail.com>
 * @copyright  2007-2021 ETS-Soft
 * @license    Valid for 1 web site (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

class AdminETSEMDownloadController extends ModuleAdminController
{
    static $check_files = [
        'ets_migrate_connector.zip',
        'ets_passwordkeeper.zip'
    ];

    public function init()
    {
        $filename = Tools::getValue('file');
        if (trim($filename) == '' ||
            !Validate::isFileName($filename) ||
            !(in_array($filename, self::$check_files) || preg_match('/^readme_[a-z]{2}\.pdf$/', $filename))
        ) {
            echo $this->l('File name is not valid');
            exit;
        }
        $PS_BASE_DIR = in_array($filename, self::$check_files) ? '/plugins/' : '/docs/';
        $file = $this->module->getLocalPath() . $PS_BASE_DIR . (string)preg_replace('/\.{2,}/', '.', $filename);
        if (!is_file($file)) {
            echo $this->l('File does not exist');
            exit;
        }
        /* Detect mime content type */
        $mimeType = false;
        if (function_exists('finfo_open')) {
            $finfo = @finfo_open(FILEINFO_MIME);
            $mimeType = @finfo_file($finfo, $file);
            @finfo_close($finfo);
        } elseif (function_exists('mime_content_type')) {
            $mimeType = @mime_content_type($file);
        } elseif (function_exists('exec')) {
            $mimeType = trim(call_user_func('exec', 'file -b --mime-type ' . call_user_func('escapeshellarg', $file)));
            if (!$mimeType) {
                $mimeType = trim(call_user_func('exec', 'file --mime ' . call_user_func('escapeshellarg', $file)));
            }
            if (!$mimeType) {
                $mimeType = trim(@call_user_func('exec', 'file -bi ' . call_user_func('escapeshellarg', $file)));
            }
        }

        if (empty($mimeType)) {
            $bName = basename($filename);
            $bName = explode('.', $bName);
            $bName = Tools::strtolower($bName[count($bName) - 1]);

            $mimeTypes = array(
                'ez' => 'application/andrew-inset',
                'hqx' => 'application/mac-binhex40',
                'cpt' => 'application/mac-compactpro',
                'doc' => 'application/msword',
                'oda' => 'application/oda',
                'pdf' => 'application/pdf',
                'ai' => 'application/postscript',
                'eps' => 'application/postscript',
                'ps' => 'application/postscript',
                'smi' => 'application/smil',
                'smil' => 'application/smil',
                'wbxml' => 'application/vnd.wap.wbxml',
                'wmlc' => 'application/vnd.wap.wmlc',
                'wmlsc' => 'application/vnd.wap.wmlscriptc',
                'bcpio' => 'application/x-bcpio',
                'vcd' => 'application/x-cdlink',
                'pgn' => 'application/x-chess-pgn',
                'cpio' => 'application/x-cpio',
                'csh' => 'application/x-csh',
                'dcr' => 'application/x-director',
                'dir' => 'application/x-director',
                'dxr' => 'application/x-director',
                'dvi' => 'application/x-dvi',
                'spl' => 'application/x-futuresplash',
                'gtar' => 'application/x-gtar',
                'hdf' => 'application/x-hdf',
                'js' => 'application/x-javascript',
                'skp' => 'application/x-koan',
                'skd' => 'application/x-koan',
                'skt' => 'application/x-koan',
                'skm' => 'application/x-koan',
                'latex' => 'application/x-latex',
                'nc' => 'application/x-netcdf',
                'cdf' => 'application/x-netcdf',
                'sh' => 'application/x-sh',
                'shar' => 'application/x-shar',
                'swf' => 'application/x-shockwave-flash',
                'sit' => 'application/x-stuffit',
                'sv4cpio' => 'application/x-sv4cpio',
                'sv4crc' => 'application/x-sv4crc',
                'tar' => 'application/x-tar',
                'tcl' => 'application/x-tcl',
                'tex' => 'application/x-tex',
                'texinfo' => 'application/x-texinfo',
                'texi' => 'application/x-texinfo',
                't' => 'application/x-troff',
                'tr' => 'application/x-troff',
                'roff' => 'application/x-troff',
                'man' => 'application/x-troff-man',
                'me' => 'application/x-troff-me',
                'ms' => 'application/x-troff-ms',
                'ustar' => 'application/x-ustar',
                'src' => 'application/x-wais-source',
                'xhtml' => 'application/xhtml+xml',
                'xht' => 'application/xhtml+xml',
                'zip' => 'application/zip',
                'au' => 'audio/basic',
                'snd' => 'audio/basic',
                'mid' => 'audio/midi',
                'midi' => 'audio/midi',
                'kar' => 'audio/midi',
                'mpga' => 'audio/mpeg',
                'mp2' => 'audio/mpeg',
                'mp3' => 'audio/mpeg',
                'aif' => 'audio/x-aiff',
                'aiff' => 'audio/x-aiff',
                'aifc' => 'audio/x-aiff',
                'm3u' => 'audio/x-mpegurl',
                'ram' => 'audio/x-pn-realaudio',
                'rm' => 'audio/x-pn-realaudio',
                'rpm' => 'audio/x-pn-realaudio-plugin',
                'ra' => 'audio/x-realaudio',
                'wav' => 'audio/x-wav',
                'pdb' => 'chemical/x-pdb',
                'xyz' => 'chemical/x-xyz',
                'bmp' => 'image/bmp',
                'gif' => 'image/gif',
                'ief' => 'image/ief',
                'jpeg' => 'image/jpeg',
                'jpg' => 'image/jpeg',
                'jpe' => 'image/jpeg',
                'png' => 'image/png',
                'tiff' => 'image/tiff',
                'tif' => 'image/tif',
                'djvu' => 'image/vnd.djvu',
                'djv' => 'image/vnd.djvu',
                'wbmp' => 'image/vnd.wap.wbmp',
                'ras' => 'image/x-cmu-raster',
                'pnm' => 'image/x-portable-anymap',
                'pbm' => 'image/x-portable-bitmap',
                'pgm' => 'image/x-portable-graymap',
                'ppm' => 'image/x-portable-pixmap',
                'rgb' => 'image/x-rgb',
                'xbm' => 'image/x-xbitmap',
                'xpm' => 'image/x-xpixmap',
                'xwd' => 'image/x-windowdump',
                'igs' => 'model/iges',
                'iges' => 'model/iges',
                'msh' => 'model/mesh',
                'mesh' => 'model/mesh',
                'silo' => 'model/mesh',
                'wrl' => 'model/vrml',
                'vrml' => 'model/vrml',
                'css' => 'text/css',
                'html' => 'text/html',
                'htm' => 'text/html',
                'asc' => 'text/plain',
                'txt' => 'text/plain',
                'rtx' => 'text/richtext',
                'rtf' => 'text/rtf',
                'sgml' => 'text/sgml',
                'sgm' => 'text/sgml',
                'tsv' => 'text/tab-seperated-values',
                'wml' => 'text/vnd.wap.wml',
                'wmls' => 'text/vnd.wap.wmlscript',
                'etx' => 'text/x-setext',
                'xml' => 'text/xml',
                'xsl' => 'text/xml',
                'mpeg' => 'video/mpeg',
                'mpg' => 'video/mpeg',
                'mpe' => 'video/mpeg',
                'qt' => 'video/quicktime',
                'mov' => 'video/quicktime',
                'mxu' => 'video/vnd.mpegurl',
                'avi' => 'video/x-msvideo',
                'movie' => 'video/x-sgi-movie',
                'ice' => 'x-conference-xcooltalk',
            );

            if (isset($mimeTypes[$bName])) {
                $mimeType = $mimeTypes[$bName];
            } else {
                $mimeType = 'application/octet-stream';
            }
        }

        if (ob_get_level() && ob_get_length() > 0) {
            ob_end_clean();
        }

        /* Set headers for download */
        header('Content-Transfer-Encoding: binary');
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($file));
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        //prevents max execution timeout, when reading large files
        @set_time_limit(0);
        $fp = fopen($file, 'rb');

        if ($fp && is_resource($fp)) {
            while (!feof($fp)) {
                echo fgets($fp, 16384);
            }
        }

        exit;
    }
}
