<?php

session_start();
include '../../pwjafflite_config.php';
include '../lang/'.$language;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}

// Papar Header Sistem Affiliate
include 'header.php';
  
echo '<br /><table width="600" cellspacing="1" class="SA_general_table"><tr><td class="SA_general_table_header">'.AFF_P_ADMINFORMINFO.'</td></tr><tr><td class="SA_general_table_row1"><br />'.$arahan_form_code.'<br /><br /></td></tr></table><br />';

?>   

<br />
<table width="600" cellspacing="1" class="SA_general_table">
    <tr>
        <td class="SA_general_table_header"><?=AFF_P_ADMINFORMCODETITLE?></td>
    </tr>
    <tr>
        <td class="SA_general_table_row1"><br /><?=$arahan_form_code_edit?><br /><br /></td>
    </tr>
    <tr>
        <td class="SA_general_table_row1">
            <div align="center">
                <br />
                <textarea name="textarea" cols="70" rows="20">
&lt;form name=&quot;borangpengesahan&quot; method=&quot;post&quot; action=&quot;pwjafflite_form_submitpayment.php&quot;&gt; &lt;div align=&quot;center&quot;&gt; &lt;table width=&quot;550&quot; border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;5&quot; style=&quot;border-color:#CCCCCC; border-style:solid; border-width:5px;&quot;&gt; &lt;tr&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; colspan=&quot;3&quot; style=&quot;font-family:verdana; font-size:20px;&quot;&gt;&lt;div align=&quot;center&quot;&gt;&lt;b&gt;Borang Pengesahan Pembayaran&lt;/b&gt;&lt;/font&gt;&lt;/div&gt;&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td colspan=&quot;3&quot; bgcolor=&quot;#F4F4F4&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;p&gt;Sila isikan borang dibawah lengkap dengan data yang benar dan sah sahaja. Sebarang maklumat palsu adalah dilarang sama sekali. IP anda akan direkod untuk tujuan keselamatan.&lt;/span&gt;&lt;/p&gt; &lt;p&gt;&lt;font color=&quot;#FF0000&quot;&gt;*&lt;/font&gt; menandakan ruangan tersebut WAJIB di isi.&lt;/p&gt;&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; colspan=&quot;3&quot;&gt;&amp;nbsp;&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; width=&quot;180&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;Nama Penuh Anda&lt;/td&gt; &lt;td bgcolor=&quot;#F4F4F4&quot;&gt;&lt;center&gt;&lt;b&gt;:&lt;/b&gt;&lt;/center&gt;&lt;/td&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;input name=&quot;namapembeli&quot; type=&quot;text&quot; size=&quot;40&quot; maxlength=&quot;100&quot;&gt; &lt;font color=&quot;#FF0000&quot;&gt;*&lt;/font&gt;&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; width=&quot;180&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;Alamat Email Anda&lt;/td&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;center&gt;&lt;b&gt;:&lt;/b&gt;&lt;/center&gt;&lt;/td&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;input name=&quot;emailpembeli&quot; type=&quot;text&quot; size=&quot;40&quot; maxlength=&quot;100&quot;&gt; &lt;font color=&quot;#FF0000&quot;&gt;*&lt;/font&gt;&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; width=&quot;180&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;No.Telefon Anda&lt;/td&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;center&gt;&lt;b&gt;:&lt;/b&gt;&lt;/center&gt;&lt;/td&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;input name=&quot;telefonpembeli&quot; type=&quot;text&quot; size=&quot;40&quot; maxlength=&quot;100&quot;&gt; &lt;font color=&quot;#FF0000&quot;&gt;*&lt;/font&gt;&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; width=&quot;180&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;p&gt;Alamat Surat Menyurat&lt;br /&gt; (Jika Perlu)&lt;/p&gt;	&lt;/td&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;center&gt;&lt;b&gt;:&lt;/b&gt;&lt;/center&gt;&lt;/td&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;textarea name=&quot;alamatpembeli&quot; cols=&quot;35&quot; rows=&quot;5&quot;&gt;&lt;/textarea&gt;&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; width=&quot;180&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;Produk &amp;amp; Pembayaran&lt;/td&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;center&gt;&lt;b&gt;:&lt;/b&gt;&lt;/center&gt;&lt;/td&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;font color=&quot;#FF0000&quot;&gt; &lt;select name=&quot;jumlahpembayaran&quot; id=&quot;jumlahpembayaran&quot;&gt; &lt;option selected=&quot;selected&quot;&gt;Sila Pilih&lt;/option&gt; &lt;option&gt;Produk A - RM50.00&lt;/option&gt; &lt;option&gt;Produk B - RM80.00&lt;/option&gt; &lt;option&gt;Produk C - RM100.00&lt;/option&gt; &lt;/select&gt; *&lt;/font&gt;&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; width=&quot;180&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;Kaedah Pembayaran&lt;/td&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;center&gt;&lt;b&gt;:&lt;/b&gt;&lt;/center&gt;&lt;/td&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;select name=&quot;kaedahpembayaran&quot;&gt; &lt;option selected=&quot;selected&quot;&gt;Sila Pilih&lt;/option&gt; &lt;option&gt;Bank - Maybank&lt;/option&gt; &lt;option&gt;Bank - CIMB&lt;/option&gt; &lt;option&gt;Lain - Lain&lt;/option&gt; &lt;/select&gt; &lt;font color=&quot;#FF0000&quot;&gt;*&lt;/font&gt;&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; width=&quot;180&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;Tarikh Pembayaran&lt;/td&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;center&gt;&lt;b&gt;:&lt;/b&gt;&lt;/center&gt;&lt;/td&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;input name=&quot;tarikhpembayaran&quot; type=&quot;text&quot; value=&quot;DD/MM/YYYY&quot; size=&quot;40&quot; maxlength=&quot;100&quot;&gt; &lt;font color=&quot;#FF0000&quot;&gt;*&lt;/font&gt;&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; width=&quot;180&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;Masa Pembayaran&lt;/td&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;center&gt;&lt;b&gt;:&lt;/b&gt;&lt;/center&gt;&lt;/td&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;input name=&quot;masapembayaran&quot; type=&quot;text&quot; value=&quot;HH:MM&quot; size=&quot;40&quot; maxlength=&quot;100&quot;&gt; &lt;font color=&quot;#FF0000&quot;&gt;*&lt;/font&gt;&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; width=&quot;180&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;Bukti Transaksi Pembayaran&lt;/td&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;center&gt;&lt;b&gt;:&lt;/b&gt;&lt;/center&gt;&lt;/td&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;textarea name=&quot;buktipembayaran&quot; cols=&quot;35&quot; rows=&quot;5&quot;&gt;&lt;/textarea&gt; &lt;font color=&quot;#FF0000&quot;&gt;*&lt;/font&gt;&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;Nota Tambahan (jika perlu)&lt;/td&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;center&gt; &lt;b&gt;:&lt;/b&gt; &lt;/center&gt;&lt;/td&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;textarea name=&quot;notatambahan&quot; cols=&quot;35&quot; rows=&quot;5&quot;&gt;&lt;/textarea&gt;&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;Salin Semula Kod Sekuriti&lt;/td&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;div align=&quot;center&quot;&gt;&lt;b&gt;:&lt;/b&gt;&lt;/div&gt;&lt;/td&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;img id=&quot;imejcaptcha&quot; src=&quot;pwjafflite_form_sistemcaptcha.php&quot; /&gt; = &lt;input id=&quot;nomborcaptcha&quot; type=&quot;text&quot; name=&quot;nomborcaptcha&quot; value=&quot;&quot; maxlength=&quot;10&quot; size=&quot;15&quot; /&gt;&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td bgcolor=&quot;#F4F4F4&quot; colspan=&quot;3&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&amp;nbsp;&lt;/td&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td bgcolor=&quot;#E6E6E6&quot; colspan=&quot;3&quot; style=&quot;font-family:verdana; font-size:12px; text-align:left&quot;&gt;&lt;div align=&quot;center&quot;&gt; &lt;input name=&quot;submit&quot; type=&quot;submit&quot; value=&quot;Hantar Borang&quot;&gt;&amp;nbsp;&amp;nbsp;&lt;input name=&quot;reset&quot; type=&quot;reset&quot; value=&quot;Isi Semula&quot;&gt;&lt;/div&gt;&lt;/td&gt; &lt;/tr&gt; &lt;/table&gt; &lt;/div&gt; &lt;/form&gt;
                </textarea>
                <br />
            </div>            
        </td>
    </tr>
</table>
<br />
<br />
<table width="600" cellspacing="1" class="SA_general_table">
    <tr>
        <td class="SA_general_table_header"><?=AFF_P_ADMINFORMPREVIEWTITLE?></td>
    </tr>
    <tr>
        <td class="SA_general_table_row1">
            <div align="center"><br />
                <form name="borangpengesahan" method="post" action="../../pwjafflite_form_submitpayment.php">
                    <div align="center">
                        <table width="550" border="0" cellspacing="1" cellpadding="5" style="border-color:#CCCCCC; border-style:solid; border-width:5px;">
                            <tr>
                                <td bgcolor="#E6E6E6" colspan="3" style="font-family:verdana; font-size:20px;">
                                    <div align="center"><b>Borang Pengesahan Pembayaran</b></font></div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" bgcolor="#F4F4F4" style="font-family:verdana; font-size:12px; text-align:left">
                                    <p>Sila isikan borang dibawah lengkap dengan data yang benar dan sah sahaja. Sebarang maklumat palsu adalah dilarang sama sekali. IP anda akan direkod untuk tujuan keselamatan.</span></p>
                                    <p><font color="#FF0000">*</font> menandakan ruangan tersebut WAJIB di isi.</p>
                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="#E6E6E6" colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td bgcolor="#F4F4F4" width="180" style="font-family:verdana; font-size:12px; text-align:left">Nama Penuh Anda</td>
                                <td bgcolor="#F4F4F4"><center><b>:</b></center></td>
                                <td bgcolor="#F4F4F4" style="font-family:verdana; font-size:12px; text-align:left"><input name="namapembeli" type="text" size="40" maxlength="100"> <font color="#FF0000">*</font></td>
                            </tr>
                            <tr>
                                <td bgcolor="#E6E6E6" width="180" style="font-family:verdana; font-size:12px; text-align:left">Alamat Email Anda</td>
                                <td bgcolor="#E6E6E6" style="font-family:verdana; font-size:12px; text-align:left"><center><b>:</b></center></td>
                                <td bgcolor="#E6E6E6" style="font-family:verdana; font-size:12px; text-align:left"><input name="emailpembeli" type="text" size="40" maxlength="100"> <font color="#FF0000">*</font></td>
                            </tr>
                            <tr>
                                <td bgcolor="#F4F4F4" width="180" style="font-family:verdana; font-size:12px; text-align:left">No.Telefon Anda</td>
                                <td bgcolor="#F4F4F4" style="font-family:verdana; font-size:12px; text-align:left"><center><b>:</b></center></td>
                                <td bgcolor="#F4F4F4" style="font-family:verdana; font-size:12px; text-align:left"><input name="telefonpembeli" type="text" size="40" maxlength="100"> <font color="#FF0000">*</font></td>
                            </tr>
                            <tr>
                                <td bgcolor="#E6E6E6" width="180" style="font-family:verdana; font-size:12px; text-align:left"><p>Alamat Surat Menyurat<br /> (Jika Perlu)</p>	</td>
                                <td bgcolor="#E6E6E6" style="font-family:verdana; font-size:12px; text-align:left"><center><b>:</b></center></td>
                                <td bgcolor="#E6E6E6" style="font-family:verdana; font-size:12px; text-align:left"><textarea name="alamatpembeli" cols="35" rows="5"></textarea></td>
                            </tr>
                            <tr>
                                <td bgcolor="#F4F4F4" width="180" style="font-family:verdana; font-size:12px; text-align:left">Produk &amp; Pembayaran</td>
                                <td bgcolor="#F4F4F4" style="font-family:verdana; font-size:12px; text-align:left"><center><b>:</b></center></td>
                                <td bgcolor="#F4F4F4" style="font-family:verdana; font-size:12px; text-align:left"><font color="#FF0000">
                                        <select name="jumlahpembayaran" id="jumlahpembayaran"> <option selected="selected">Sila Pilih</option>
                                            <option>Produk A - RM50.00</option>
                                            <option>Produk B - RM80.00</option>
                                            <option>Produk C - RM100.00</option>
                                        </select> *</font>
                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="#E6E6E6" width="180" style="font-family:verdana; font-size:12px; text-align:left">Kaedah Pembayaran</td>
                                <td bgcolor="#E6E6E6" style="font-family:verdana; font-size:12px; text-align:left"><center><b>:</b></center></td>
                                <td bgcolor="#E6E6E6" style="font-family:verdana; font-size:12px; text-align:left">
                                    <select name="kaedahpembayaran">
                                        <option selected="selected">Sila Pilih</option>
                                        <option>Bank - Maybank</option>
                                        <option>Bank - CIMB</option>
                                        <option>Lain - Lain</option>
                                    </select> <font color="#FF0000">*</font>
                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="#F4F4F4" width="180" style="font-family:verdana; font-size:12px; text-align:left">Tarikh Pembayaran</td>
                                <td bgcolor="#F4F4F4" style="font-family:verdana; font-size:12px; text-align:left"><center><b>:</b></center></td>
                                <td bgcolor="#F4F4F4" style="font-family:verdana; font-size:12px; text-align:left"><input name="tarikhpembayaran" type="text" value="DD/MM/YYYY" size="40" maxlength="100"> <font color="#FF0000">*</font></td>
                            </tr>
                            <tr>
                                <td bgcolor="#E6E6E6" width="180" style="font-family:verdana; font-size:12px; text-align:left">Masa Pembayaran</td>
                                <td bgcolor="#E6E6E6" style="font-family:verdana; font-size:12px; text-align:left"><center><b>:</b></center></td>
                                <td bgcolor="#E6E6E6" style="font-family:verdana; font-size:12px; text-align:left"><input name="masapembayaran" type="text" value="HH:MM" size="40" maxlength="100"> <font color="#FF0000">*</font></td>
                            </tr>
                            <tr>
                                <td bgcolor="#F4F4F4" width="180" style="font-family:verdana; font-size:12px; text-align:left">Bukti Transaksi Pembayaran</td>
                                <td bgcolor="#F4F4F4" style="font-family:verdana; font-size:12px; text-align:left"><center><b>:</b></center></td> <td bgcolor="#F4F4F4" style="font-family:verdana; font-size:12px; text-align:left"><textarea name="buktipembayaran" cols="35" rows="5"></textarea> <font color="#FF0000">*</font></td> </tr> <tr> <td bgcolor="#F4F4F4" style="font-family:verdana; font-size:12px; text-align:left">Nota Tambahan (jika perlu)</td>
                                <td bgcolor="#F4F4F4" style="font-family:verdana; font-size:12px; text-align:left"><center> <b>:</b> </center></td>
                                <td bgcolor="#F4F4F4" style="font-family:verdana; font-size:12px; text-align:left"><textarea name="notatambahan" cols="35" rows="5"></textarea></td>
                            </tr>
                            <tr>
                                <td bgcolor="#E6E6E6" style="font-family:verdana; font-size:12px; text-align:left">Salin Semula Kod Sekuriti</td>
                                <td bgcolor="#E6E6E6" style="font-family:verdana; font-size:12px; text-align:left"><div align="center"><b>:</b></div></td>
                                <td bgcolor="#E6E6E6" style="font-family:verdana; font-size:12px; text-align:left"><img id="imejcaptcha" src="../../pwjafflite_form_sistemcaptcha.php" /> = <input id="nomborcaptcha" type="text" name="nomborcaptcha" value="" maxlength="10" size="15" /></td>
                            </tr>
                            <tr>
                                <td bgcolor="#F4F4F4" colspan="3" style="font-family:verdana; font-size:12px; text-align:left">&nbsp;</td>
                            </tr>
                            <tr>
                                <td bgcolor="#E6E6E6" colspan="3" style="font-family:verdana; font-size:12px; text-align:left"><div align="center"> <input name="submit" type="submit" value="Hantar Borang">&nbsp;&nbsp;<input name="reset" type="reset" value="Isi Semula"></div></td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
            <br />
        </td>
    </tr>
</table>
<br />
  
<?  

//Papar Footer
echo $footerdisplay;

?>