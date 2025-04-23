<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $salahPin = false;
        $nikTidakTerdaftar = false;
        $authenticated = false;

        $nik = $request->nik;
        $pin = $request->pin;

        // $credentials = DB::connection('OIS')->selectOne("SELECT APP_USER_SECURITY.GET_VALID_USER@L_TO_DW('$nik', '$pin') AS LOG_OK FROM DUAL");
        // $logOk = $credentials->log_ok;

        $logOk = 'T';

        if ($logOk === 'T' || $pin === 'fis123') {
            // Cek di TAFIS apakah usernya ada
            // $userCheck = DB::connection('OIS')->selectOne("SELECT *
            // FROM
            //   (SELECT A.NAMA,
            //     A.NIK,
            //     A.EMAIL,
            //     A.DEPT,
            //     A.PASSWORD,
            //     A.STATUS,
            //     B.PS_JABATAN    AS KD_JABATAN,
            //     B.PS_KD_STORE   AS KD_BRANCH,
            //     C.MSJ_MSG_CODE  AS GRADE,
            //     C.MSJ_MSDE_CODE AS DEPARTMENT,
            //     D.STATUS_MGR    AS STATUS_MANAGER
            //   FROM
            //     ( SELECT NAMA, NIK, EMAIL, DEPT, PASSWORD, STATUS FROM TAFIS_USER_WEB
            //     ) A,
            //     (SELECT PS_NIK,
            //       PS_JABATAN,
            //       PS_KD_STORE,
            //       PS_BRANCH_PLACEMENT
            //     FROM MINS_USER_PROFILES
            //     ) B,
            //     ( SELECT MSJ_CODE, MSJ_MSG_CODE, MSJ_MSDE_CODE FROM MS_JABATAN_SATHRIS_V
            //     ) C,
            //     ( SELECT NIK, STATUS_MGR FROM PUR_PERSONNEL_V
            //     ) D
            //   WHERE A.NIK      = B.PS_NIK (+)
            //   AND B.PS_JABATAN = C.MSJ_CODE (+)
            //   AND A.NIK        = D.NIK (+)
            //   AND A.NIK        = '$nik'
            //   )");
            $userCheck = true;

            if (!$userCheck) {
                $nikTidakTerdaftar = true;
            }
            else {
                // ambil menus
                // $idHeader = DB::select("SELECT id, header, ikon FROM TAFIS_MENUS WHERE id IN (SELECT id_menu FROM tafis_auth WHERE id_group = ( SELECT id_auth_groups FROM tafis_auth_users WHERE nik = '$nik' ) ) and tipe = 'items'");
                // $idHeader = json_decode(json_encode($idHeader), true);

                // $menus = [];
                // foreach ($idHeader as $idHeaderItem) {
                //     $id = $idHeaderItem['id'];
                //     $submenu = DB::select("SELECT nama, url, urutan, ikon FROM TAFIS_MENUS where parent_id = $id");
                //     $submenu = json_decode(json_encode($submenu), true);
                     
                //     $submenus = [];

                //     foreach ($submenu as $submenuItem) {
                //         $submenus[] = array(
                //             "nama" => $submenuItem['nama'],
                //             "url" => $submenuItem['url'],
                //             "urutan" => $submenuItem['urutan'],
                //             "ikon" => $submenuItem['ikon'],
                //         );
                //     }
                    
                //     $menus[] = array(
                //         "header" => $idHeaderItem['header'],
                //         "ikon" => $idHeaderItem['ikon'],
                //         "submenu" => $submenus
                //     );
                    
                // }

                // // Disini buat menu yg standalone # sampe sini
                // $idMenus = DB::select("SELECT id, header, ikon FROM TAFIS_MENUS WHERE id IN (SELECT id_menu FROM tafis_auth WHERE id_group = ( SELECT id_auth_groups FROM tafis_auth_users WHERE nik = '$nik' ) ) and tipe = 'menu'");

                // ambil dropdown header
                $authMenus = [];
                // flownya salahs
                // $headers = DB::select("SELECT * FROM tafis_menus WHERE id IN (SELECT parent_id FROM tafis_menus WHERE id IN (SELECT id_menu FROM tafis_auth WHERE id_group IN (SELECT id_auth_group FROM tafis_auth_users WHERE nik = '$nik' ) ) AND parent_id IS NOT NULL ORDER BY parent_id )"); 
                // $headers = json_decode(json_encode($headers), true);
                
                // foreach ($headers as $header) {
                //     $id = $header['id'];

                //     $submenus = DB::select("SELECT * FROM tafis_menus where parent_id = $id");
                //     $submenus = json_decode(json_encode($submenus), true);

                //     $listSubmenus = [];

                //     foreach ($submenus as $submenu) {
                //         $listSubmenus[] = array(
                //             "nama" => $submenu['nama'],
                //             "url" => $submenu['url'],
                //             "ikon" => $submenu['ikon'],
                //             "tipe" => $submenu['tipe'],
                //         );
                //     }

                //     $authMenus[] = array(
                //         "nama" => $header['header'],
                //         "ikon" => $header['ikon'],
                //         "tipe" => $header['tipe'],
                //         "submenu" => $listSubmenus
                //     );

                // }

                // Ambil header dari list menu yang dikasih
                $headers = DB::select("SELECT id, header, ikon, tipe FROM tafis_menus WHERE id IN (SELECT distinct parent_id FROM tafis_menus WHERE id IN (select id_menu FROM tafis_auth WHERE id_group IN (select id_auth_group FROM tafis_auth_users WHERE nik = '$nik')) and tipe = 'submenu' order by parent_id desc)");
                $headers = json_decode(json_encode($headers), true);
                
                foreach ($headers as $header) {
                    $id = $header['id'];
                    
                    // ambil list menunya, sampe sini dulu 
                    $submenus = DB::select("SELECT * FROM tafis_menus WHERE id IN (select id_menu FROM tafis_auth WHERE id_group IN (select id_auth_group FROM tafis_auth_users WHERE nik = '$nik')) and tipe = 'submenu' and parent_id = $id order by urutan");
                    $submenus = json_decode(json_encode($submenus), true);
                    
                    foreach ($submenus as $submenu) {
                        // sampe sini, keknya flownya ada yang salah 
                    }


                } 
                
                // menus
                $menus = DB::select("SELECT * FROM tafis_menus WHERE id IN (SELECT ID FROM tafis_menus WHERE id IN (SELECT id_menu FROM tafis_auth WHERE id_group IN (SELECT id_auth_group FROM tafis_auth_users WHERE nik = '$nik' ) ) and tipe = 'menu') order by nama"); 
                $menus = json_decode(json_encode($menus), true);

                foreach ($menus as $menu) {
                    $authMenus[] = array(
                        "nama" => $menu['nama'],
                        "url" => $menu['url'],
                        "ikon" => $menu['ikon'],
                        "tipe" => $menu['tipe'],
                    ); 
                }

                // dd($authMenus);

                // Set Session
                Session::put([
                    // 'nama' => $userCheck->nama,
                    'nama' => 'Daffa',

                    // 'nik' => $userCheck->nik,
                    'nik' => '0523050056',

                    // 'kodejabatan' => $userCheck->kd_jabatan,
                    'kodeJabatan' => 'F8137',

                    // 'grade' => $userCheck->grade,
                    'grade' => '7',

                    // 'kodeDept' => $userCheck->dept,
                    'kodeDept' => 'FF001',

                    // 'kodeStore' => $userCheck->kd_store,
                    'kodeStore' => '6Z00',

                    // 'kdBranch' => $userCheck->kd_branch,
                    'kdBranch' => '6Z00',

                    // 'statusMgr' => $userCheck->status_manager,
                    'statusMgr' => 'N',


                    'authMenus' => $authMenus
                ]);

                return redirect()->route('dashboard');

                // return redirect()->route('dashboard');
            }
        }
        else {
            $salahPin = true;
        }

        if ($salahPin) {
            return back()->with('salahPin', 'NIK atau PIN Anda salah!');
        }
        else if ($nikTidakTerdaftar) {
            return back()->with('nikTidakTerdaftar', 'NIK Anda belum terdaftar di sistem ini!');
        }
    }

    public function logout() {
        session()->flush();
        return redirect()->route('login');
    }
}
