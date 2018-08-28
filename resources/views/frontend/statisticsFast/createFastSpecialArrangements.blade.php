@extends('frontend.layouts.index')
@section('content')

    <div class="col-sm-7">
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Lọc - Ghép dàn đặc biệt</h4>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    VDEV Company: Hỗ trợ lọc ghép dàn chuyên nghiệp chính xác nhất. Dàn số cách nhau bằng dấu phẩy. Mỗi số gồm có 2 chữ số.
                </div>
                <div>
                    <script src="frontend/js/tao_dan.js" type=""></script>
                    <legend class="kqvertimarginw dosam">
                        <p class="text-center">Lấy nhanh dàn đặc biệt</p>
                    </legend>
                    <br>
                    <table id="MainContent_tabLayNhanh" class="kqcenter" style="width:100%;">
                        <tbody>
                        <tr>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('dauchan')" value="Đầu chẵn" id="MainContent_Button1" style="background-color:#66FFFF;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('daule')" value="Đầu lẻ" id="MainContent_Button2" style="background-color:#66FFFF;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('daube')" value="Đầu bé" id="MainContent_Button3" style="background-color:#66FFFF;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('daulon')" value="Đầu lớn" id="MainContent_Button4" style="background-color:#66FFFF;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('duoichan')" value="Đuôi chẵn" id="MainContent_Button5" style="background-color:#FFFF99;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('duoile')" value="Đuôi lẻ" id="MainContent_Button6" style="background-color:#FFFF99;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('duoibe')" value="Đuôi bé" id="MainContent_Button7" style="background-color:#FFFF99;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('duoilon')" value="Đuôi lớn" id="MainContent_Button8" style="background-color:#FFFF99;width:76px; padding:0; margin:5px 0;">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('tongchan')" value="Tổng chẵn" id="MainContent_Button9" style="background-color:#FF99FF;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('tongle')" value="Tổng lẻ" id="MainContent_Button10" style="background-color:#FF99FF;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('tongbe')" value="Tổng bé" id="MainContent_Button11" style="background-color:#FF99FF;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('tonglon')" value="Tổng lớn" id="MainContent_Button12" style="background-color:#FF99FF;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('chanchan')" value="Chẵn chẵn" id="MainContent_Button13" style="background-color:#FF9999;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('chanle')" value="Chẵn lẻ" id="MainContent_Button14" style="background-color:#FF9999;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('lechan')" value="Lẻ chẵn" id="MainContent_Button15" style="background-color:#FF9999;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('lele')" value="Lẻ lẻ" id="MainContent_Button16" style="background-color:#FF9999;width:76px; padding:0; margin:5px 0;">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('bebe')" value="Bé bé" id="MainContent_Button17" style="background-color:#66CCFF;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('belon')" value="Bé lớn" id="MainContent_Button18" style="background-color:#66CCFF;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('lonbe')" value="Lớn bé" id="MainContent_Button19" style="background-color:#66CCFF;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('lonlon')" value="Lớn lớn" id="MainContent_Button20" style="background-color:#66CCFF;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('kepbang')" value="Kép bằng" id="MainContent_Button21" style="background-color:#99FF66;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('keplech')" value="Kép lệch" id="MainContent_Button22" style="background-color:#99FF66;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('kepam')" value="Kép âm" id="MainContent_Button23" style="background-color:#99FF66;width:76px; padding:0; margin:5px 0;">
                            </td>
                            <td>
                                <input type="submit" onclick="return LayDanNhanh('satkep')" value="Sát kép" id="MainContent_Button24" style="background-color:#99FF66;width:76px; padding:0; margin:5px 0;">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="tool-div pad5">
                        <div class="tool-result-box" id="taodan_div" style="width:100% !important">
                            <ul id="taodan_ul" class="tool-ul" style="padding: 10px 18px"></ul>
                        </div>
                    </div>
                    <legend class="kqvertimarginw dosam" style="padding-top: 20px !important">
                        <p class="text-center">Tạo dàn đặc biệt</p>
                    </legend>
                    <table id="MainContent_Table14" style="width:100%;">
                        <tbody>
                        <tr>
                            <td class="pad2" style="padding-top: 20px !important">
                                <table id="MainContent_Table1" style="background-color:#CCFFCC;border-width:1px;border-style:Ridge;">
                                    <tbody>
                                    <tr valign="bottom">
                                        <td class="pad2">
                                            <table id="MainContent_Table2">
                                                <tbody>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="Table1">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:60px;"><span id="MainContent_Label1" style="display:inline-block;width:60px;">Đầu</span></td>
                                                                <td class="pad2"><span id="MainContent_Label6">+</span></td>
                                                                <td style="width:60px;"><span id="MainContent_Label2" style="display:inline-block;width:60px;">Đuôi</span></td>
                                                                <td class="pad2"><span id="MainContent_Label7">+</span></td>
                                                                <td style="width:60px;"><span id="MainContent_Label3" style="display:inline-block;width:60px;">Tổng</span></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table5">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:60px;"><input type="text" id="MainContent_txtDau1" style="width:60px;text-align:center"></td>
                                                                <td class="pad2"><span id="MainContent_Label8">+</span></td>
                                                                <td style="width:60px;"><input type="text" id="MainContent_txtDuoi1" style="width:60px;text-align:center"></td>
                                                                <td class="pad2"><span id="MainContent_Label9">+</span></td>
                                                                <td style="width:60px;"><input type="text" id="MainContent_txtTong1" style="width:60px;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table24" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td class="pad2"><span id="MainContent_Label31" style="display:inline-block;width:40px;">Thêm</span></td>
                                                                <td style="width:100%;"><input type="text" id="MainContent_txtCong1" style="width:98%;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table3" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td class="pad2"><span id="MainContent_Label4" style="display:inline-block;width:40px;">Bỏ</span></td>
                                                                <td style="width:100%;"><input type="text" id="MainContent_txtTru1" style="width:98%;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="width:100%;">
                                            <table id="MainContent_Table4" style="width:100%;">
                                                <tbody>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table28" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:15%;"><input type="submit" onclick="return TaoDanF1()" value="Tạo dàn" id="MainContent_btnCreate1"></td>
                                                                <td style="width:15%;"><input type="submit" onclick="return     ReTaoDanF1()" value="Làm lại" id="MainContent_btnClear1"></td>
                                                                <td valign="bottom" style="height:28px;width:70%;"><span id="MainContent_Label5" style="display:inline-block;height:28px;">Kết quả</span></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100%;"><textarea rows="2" cols="20" id="MainContent_txtDan1" style="font-size:Large;height:95px;width:99%;"></textarea></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td class="pad2">
                                <table id="MainContent_Table6" style="background-color:#FFCCFF;border-width:1px;border-style:Ridge;display:none;">
                                    <tbody>
                                    <tr valign="bottom">
                                        <td class="pad2">
                                            <table id="MainContent_Table7">
                                                <tbody>
                                                <tr>
                                                    <td class="pad2" style="padding-top: 20px">
                                                        <table id="MainContent_Table8">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:60px;"><span id="MainContent_Label10" style="display:inline-block;width:60px;">Đầu</span></td>
                                                                <td class="pad2"><span id="MainContent_Label11">x</span></td>
                                                                <td style="width:60px;"><span id="MainContent_Label12" style="display:inline-block;width:60px;">Đuôi</span></td>
                                                                <td class="pad2"><span id="MainContent_Label13">x</span></td>
                                                                <td style="width:60px;"><span id="MainContent_Label14" style="display:inline-block;width:60px;">Tổng</span></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table9">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:60px;"><input type="text" id="MainContent_txtDau2" style="width:60px;text-align:center"></td>
                                                                <td class="pad2"><span id="MainContent_Label15">x</span></td>
                                                                <td style="width:60px;"><input type="text" id="MainContent_txtDuoi2" style="width:60px;text-align:center"></td>
                                                                <td class="pad2"><span id="MainContent_Label16">x</span></td>
                                                                <td style="width:60px;"><input type="text" id="MainContent_txtTong2" style="width:60px;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table10" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td class="pad2"><span id="MainContent_Label17" style="display:inline-block;width:40px;">Thêm</span></td>
                                                                <td style="width:100%;"><input type="text" id="MainContent_txtCong2" style="width:98%;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table11" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td class="pad2"><span id="MainContent_Label18" style="display:inline-block;width:40px;">Bỏ</span></td>
                                                                <td style="width:100%;"><input type="text" id="MainContent_txtTru2" style="width:98%;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="width:100%;">
                                            <table id="MainContent_Table12" style="width:100%;">
                                                <tbody>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table13" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:15%;"><input type="submit" value="Tạo dàn" id="MainContent_btnCreate2"></td>
                                                                <td style="width:15%;"><input type="submit" value="Làm lại" id="MainContent_btnClear2"></td>
                                                                <td style="height:28px;"><span id="MainContent_Label19" style="display:inline-block;height:28px;">Kết quả</span></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100%;"><textarea rows="2" cols="20" id="MainContent_txtDan2" style="font-size:Large;height:95px;width:99%;"></textarea></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="pad2" style="padding-top: 20px !important">
                                <table id="MainContent_Table15" style="background-color:#CCFFCC;border-width:1px;border-style:Ridge;">
                                    <tbody>
                                    <tr valign="bottom">
                                        <td class="pad2">
                                            <table id="MainContent_Table16" style="width:235px;">
                                                <tbody>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table17">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:120px;"><span id="MainContent_Label20" style="display:inline-block;width:120px;">Chạm</span></td>
                                                                <td class="pad2"><span id="MainContent_Label21">+</span></td>
                                                                <td style="width:60px;"><span id="MainContent_Label22" style="display:inline-block;width:60px;">Tổng</span></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table18">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:120px;"><input type="text" id="MainContent_txtCham1" style="width:120px;text-align:center"></td>
                                                                <td class="pad2"><span id="MainContent_Label25">+</span></td>
                                                                <td style="width:60px;"><input type="text" id="MainContent_txtTong3" style="width:60px;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table19" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td class="pad2"><span id="MainContent_Label27" style="display:inline-block;width:40px;">Thêm</span></td>
                                                                <td style="width:100%;"><input type="text" id="MainContent_txtCong3" style="width:98%;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table20" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td class="pad2"><span id="MainContent_Label28" style="display:inline-block;width:40px;">Bỏ</span></td>
                                                                <td style="width:100%;"><input type="text" id="MainContent_txtTru3" style="width:98%;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="width:100%;">
                                            <table id="MainContent_Table21" style="width:100%;">
                                                <tbody>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table22" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:15%;"><input type="submit" onclick="return TaoDanChamTong()" value="Tạo dàn" id="MainContent_btnCreate3"></td>
                                                                <td style="width:15%;"><input type="submit" onclick="return     ReTaoDanChamTong()" value="Làm lại" id="MainContent_btnClear3"></td>
                                                                <td style="height:28px;"><span id="MainContent_Label29" style="display:inline-block;height:28px;">Kết quả</span></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100%;"><textarea rows="2" cols="20" id="MainContent_txtDan3" style="font-size:Large;height:95px;width:99%;"></textarea></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td class="pad2" style="padding-top:20px !important">
                                <table id="MainContent_Table23" style="background-color:#FFCCFF;border-width:1px;border-style:Ridge;display:none;">
                                    <tbody>
                                    <tr valign="bottom">
                                        <td class="pad2">
                                            <table id="MainContent_Table25" style="width:235px;">
                                                <tbody>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table26">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:120px;"><span id="MainContent_Label30" style="display:inline-block;width:120px;">Chạm</span></td>
                                                                <td class="pad2"><span id="MainContent_Label32">x</span></td>
                                                                <td style="width:60px;"><span id="MainContent_Label33" style="display:inline-block;width:60px;">Tổng</span></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table27">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:120px;"><input type="text" id="MainContent_txtCham2" style="width:120px;text-align:center"></td>
                                                                <td class="pad2"><span id="MainContent_Label36">x</span></td>
                                                                <td style="width:60px;"><input type="text" id="MainContent_txtTong4" style="width:60px;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table29" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td class="pad2"><span id="MainContent_Label38" style="display:inline-block;width:40px;">Thêm</span></td>
                                                                <td style="width:100%;"><input type="text" id="MainContent_txtCong4" style="width:98%;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table30" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td class="pad2"><span id="MainContent_Label39" style="display:inline-block;width:40px;">Bỏ</span></td>
                                                                <td style="width:100%;"><input type="text" id="MainContent_txtTru4" style="width:98%;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="width:100%;">
                                            <table id="MainContent_Table31" style="width:100%;">
                                                <tbody>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table32" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:15%;"><input type="submit" value="Tạo dàn" id="MainContent_btnCreate4"></td>
                                                                <td style="width:15%;"><input type="submit" value="Làm lại" id="MainContent_btnClear4"></td>
                                                                <td style="height:28px;"><span id="MainContent_Label40" style="display:inline-block;height:28px;">Kết quả</span></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100%;"><textarea rows="2" cols="20" id="MainContent_txtDan4" style="font-size:Large;height:95px;width:99%;"></textarea></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="pad2" style="padding-top: 20px !important">
                                <table id="MainContent_Table33" style="background-color:#CCFFCC;border-width:1px;border-style:Ridge;">
                                    <tbody>
                                    <tr valign="bottom">
                                        <td class="pad2">
                                            <table id="MainContent_Table34" style="width:235px;">
                                                <tbody>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table35">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:120px;"><span id="MainContent_Label23" style="display:inline-block;width:120px;">Bộ</span></td>
                                                                <td class="pad2"><span id="MainContent_Label24">+</span></td>
                                                                <td style="width:60px;"><span id="MainContent_Label26" style="display:inline-block;width:60px;">Tổng</span></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table36">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:10px;"><input type="text" id="MainContent_txtBo1" style="width:120px;text-align:center"></td>
                                                                <td class="pad2"><span id="MainContent_Label34">+</span></td>
                                                                <td style="width:60px;"><input type="text" id="MainContent_txtTong5" style="width:60px;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table37" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td class="pad2"><span id="MainContent_Label35" style="display:inline-block;width:40px;">Thêm</span></td>
                                                                <td style="width:100%;"><input type="text" id="MainContent_txtCong5" style="width:98%;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table38" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td class="pad2"><span id="MainContent_Label37" style="display:inline-block;width:40px;">Bỏ</span></td>
                                                                <td style="width:100%;"><input type="text" id="MainContent_txtTru5" style="width:98%;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="width:100%;">
                                            <table id="MainContent_Table39" style="width:100%;">
                                                <tbody>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table40" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:15%;"><input type="submit" onclick="return TaoDanBong()" value="Tạo dàn" id="MainContent_btnCreate5"></td>
                                                                <td style="width:15%;"><input type="submit" onclick="return     ReTaoDanBong()" value="Làm lại" id="MainContent_btnClrear5"></td>
                                                                <td style="height:28px;"><span id="MainContent_Label41" style="display:inline-block;height:28px;">Kết quả</span></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100%;"><textarea rows="2" cols="20" id="MainContent_txtDan5" style="font-size:Large;height:95px;width:99%;"></textarea></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td class="pad2">
                                <table id="MainContent_Table41" style="background-color:#FFCCFF;border-width:1px;border-style:Ridge;display:none;">
                                    <tbody>
                                    <tr valign="bottom">
                                        <td class="pad2">
                                            <table id="MainContent_Table42" style="width:235px;">
                                                <tbody>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table43">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:120px;"><span id="MainContent_Label42" style="display:inline-block;width:120px;">Bộ</span></td>
                                                                <td class="pad2"><span id="MainContent_Label43">x</span></td>
                                                                <td style="width:60px;"><span id="MainContent_Label44" style="display:inline-block;width:60px;">Tổng</span></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table44">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:120px;"><input type="text" id="MainContent_txtBo2" style="width:120px;text-align:center"></td>
                                                                <td class="pad2"><span id="MainContent_Label45">x</span></td>
                                                                <td style="width:60px;"><input type="text" id="MainContent_txtTong6" style="width:60px;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table45" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td class="pad2"><span id="MainContent_Label46" style="display:inline-block;width:40px;">Thêm</span></td>
                                                                <td style="width:100%;"><input type="text" id="MainContent_txtCong6" style="width:98%;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table46" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td class="pad2"><span id="MainContent_Label47" style="display:inline-block;width:40px;">Bỏ</span></td>
                                                                <td style="width:100%;"><input type="text" id="MainContent_txtTru6" style="width:98%;text-align:center"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="width:100%;">
                                            <table id="MainContent_Table47" style="width:100%;">
                                                <tbody>
                                                <tr>
                                                    <td class="pad2">
                                                        <table id="MainContent_Table48" style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td style="width:15%;"><input type="submit" value="Tạo dàn" id="MainContent_btnCreate6"></td>
                                                                <td style="width:15%;"><input type="submit" value="Làm lại" id="MainContent_btnClear6"></td>
                                                                <td style="height:28px;"><span id="MainContent_Label48" style="display:inline-block;height:28px;">Kết quả</span></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100%;"><textarea rows="2" cols="20" id="MainContent_txtDan6" style="font-size:Large;height:95px;width:99%;"></textarea></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@section('navRightTop')
    @include('frontend.block.newsLottery')
@endsection
@section('navRightBottom')
    @include('frontend.block.navRight')
@endsection
@endsection