-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2013 at 01:24 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cmsid_22_0_356`
--

-- --------------------------------------------------------

--
-- Table structure for table `iw_options`
--

CREATE TABLE IF NOT EXISTS `iw_options` (
  `option_name` varchar(68) NOT NULL,
  `option_value` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `iw_options`
--

INSERT INTO `iw_options` (`option_name`, `option_value`) VALUES
('template', 'portal'),
('stylesheet', 'portal'),
('sitename', 'ID CMS | Content Management System Indonesia'),
('sitedescription', 'Keterangan dari website'),
('sitekeywords', 'keyword website'),
('admin_email', 'id.hpaherba@yahoo.co.id'),
('site_public', '1'),
('site_charset', 'UTF-8'),
('siteurl', 'http://localhost/cmsid/build/0.3.56'),
('home', 'http://localhost/cmsid/build/0.3.56'),
('active_plugins', '{"timer.php":"0","phpids":"0","seo.php":"0","disk-memory-usage.php":"0","statistik-view.php":"0","codemirror/codemirror.php":"0","disk-memory-usage":"0","seo":"1"}'),
('siteslogan', 'slogan website'),
('avatar_default', 'mystery'),
('html_type', 'text/html'),
('template_root', 'ares-plus'),
('stylesheet_root', 'ares-plus'),
('frontpage', 'post'),
('menu-action', '[''aksi'':{''posts'':{''title'':''Post'',''link'':''?action=post''},''pages'':{''title'':''Pages'',''link'':''?action=pages''}}]'),
('timeout', '3600'),
('login_type', 'session'),
('timezone', 'Asia/Jakarta'),
('site_copyright', 'Ã‚Â© 2012 | CMS ID'),
('recent_reg_limit', '10'),
('referal_limit', '10'),
('feed-news', '{"news_feeds":{"News Feed Local":"http://cmsid.org/rss.xml"},"display":{"desc":0,"author":0,"date":0,"limit":5}}'),
('datetime_format', 'Y/m/d'),
('avatar_default', 'mystery'),
('author', 'admin'),
('account_registration', '1'),
('text_editor', ''),
('disk_limit', '15'),
('post_comment', '1'),
('rewrite', 'advance'),
('body_layout', 'left'),
('dashboard_widget', '{"normal":"dashboard_update_info,dashboard_refering,dashboard_feed_news,","side":"dashboard_quick_post,dashboard_recent_registration,"}'),
('header-notif-x', '1');

-- --------------------------------------------------------

--
-- Table structure for table `iw_post`
--

CREATE TABLE IF NOT EXISTS `iw_post` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(80) NOT NULL,
  `date_post` datetime NOT NULL,
  `title` text NOT NULL,
  `content` longtext NOT NULL,
  `mail` varchar(160) NOT NULL,
  `post_topic` bigint(20) NOT NULL,
  `hits` int(11) NOT NULL,
  `tags` varchar(225) NOT NULL,
  `sefttitle` varchar(200) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `thumb` longtext NOT NULL,
  `thumb_desc` text NOT NULL,
  `approved` int(1) NOT NULL DEFAULT '0',
  `meta_keys` text NOT NULL,
  `meta_desc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Dumping data for table `iw_post`
--

INSERT INTO `iw_post` (`id`, `user_login`, `date_post`, `title`, `content`, `mail`, `post_topic`, `hits`, `tags`, `sefttitle`, `type`, `status`, `thumb`, `thumb_desc`, `approved`, `meta_keys`, `meta_desc`) VALUES
(1, 'admin', '2011-04-25 00:43:09', 'Selamat datang di ID oficial', '<p><span id="result_box" lang="en"><span>Jadikan Opensource adalah bagian dari hidupmu.</span></span></p>\r\n<p>User Demo</p>\r\n<p><span lang="en"><span> \r\n<table border="0" cellspacing="0" cellpadding="0" width="100%">\r\n<tbody>\r\n<tr>\r\n<td colspan="3"><strong>Administrator</strong></td>\r\n<td colspan="3"><strong>User</strong></td>\r\n</tr>\r\n<tr>\r\n<td width="13%">UserName</td>\r\n<td width="1%"><strong>:</strong></td>\r\n<td width="25%">admin</td>\r\n<td width="7%">UserName</td>\r\n<td width="0%"><strong>:</strong></td>\r\n<td width="54%">user</td>\r\n</tr>\r\n<tr>\r\n<td>Password</td>\r\n<td><strong>:</strong></td>\r\n<td>admin</td>\r\n<td>Password</td>\r\n<td><strong>:</strong></td>\r\n<td>user</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<br /> </span><span>Jika ada yang perlu ditanyakan silahkan hubungi   Kami<br /> <br /> </span><span>Kontak Kami<br /> </span><span>e-mail: <a href="mailto:admin@cmsid.org">@eko</a> / <a href="mailto:aay_bro@yahoo.co.id">@aay</a><br /></span><span>call / sms: +628-976-11-8097</span></span></p>', '0', 0, 0, '', 'selamat-datang-di-id-oficial', 'page', 1, '', '', 1, '', ''),
(2, 'admin', '2011-04-24 00:43:09', 'Abouts', '<p>ID(CMS) dikembangkan bulan april 2010 didirikan oleh Eko.</p><p>awal mulanya cmsid dikembangkan dengan dual language, karena keterbatasan coding dan demi meringkas cmsid menjadi lebih mudah digunakan, maka untuk sementar pengembangan dual language dihentikan sementara.</p><p><br>ID(CMS) sendiri diadobsi dari bahasa pemrograman web yang sederhana, insyaallah interfacenya mudah difahami dengan cepat.</p><p>CMS ini dikembangkan sebagai bahan pembelajaran kita bersama sama</p><p>Tujuan dari Kami yaitu:</p><p>1. memudahkan pemakaian.</p><p>2. membantu anda (pengguna) untuk membuat suatu website</p><p>3. menjadi media opensource yang diakui</p><p>4. media belajar bersama</p><p>5. dapat digunakan sesuai kebutuhan</p><p>Â </p><p>Semoga cmsid menjadi media menuangkan ide dan kreativitas bersama</p>', '0', 0, 0, '', 'abouts', 'page', 1, '', '', 1, '', ''),
(3, 'admin', '2011-08-24 14:12:39', 'Varian terbaru cms id sedang dikembangkan', '<p>Mungkin anda sedang bertanya tanya apa maksud judul diatas...</p>\r\n<p>Baiklah saya akan jelaskan maksudnya iyalah kini cms id sedang mengembangkan verian terbarunya yg powerfull ini juga berkat dari refrensi2 cms yg ada..</p>\r\n<p>Varian ini diklaim lebih mutahir dari pada versi-versi cms id sebelumnya, tidak akan saya sebutkan verian terbaru ini dikembangkan untuk cms id versi berapa, yg jelas verian ini lebih simple, mudah tapi tidak mudah untuk ditaklukkan... hehehe kyx penjinak aja...:), lebih nyaman digunkan, lebih enteng, content management tersendiri seperti themes, plugin dan application.</p>\r\n<p>ok saya tidak akan terburu buru untuk mereleasenya... karna saya ingin melihat respon dari anda masing2 pecinta cms id, baik tiu sebagai penyumbang ide, modul, maupun sempat bertanya..</p>\r\n<p>cms id varian baru ini dikembangkan pada platform yg umum digunakan, seperti</p>\r\n<p>php dan mysql versi standar, maka dari itu saya selaku admin dan pendiri id (cms id) agar anda mengirimkan kritik dan sarannya agar kami bisa lebih maju &amp; sesuai dengan keinginan anda walaupun tak sempurna, dan saya menyarankan agar anda lebih sabar menunggu kehadiran varian baru ini yg diadobsi dari dari cms cms yg pernah dibuat, kalau bisa dibilang sich mirip tapi tak sama :), itulah cms id</p>\r\n<p>&nbsp;</p>\r\n<p>salam id</p>\r\n<p>by eko</p>\r\n<p>&nbsp;</p>', '0', 4, 91, 'varian,baru,cmsid', 'varian-terbaru-cms-id-sedang-dikembangkan', 'post', 1, 'gVl9y3utKo.jpg', '', 1, '', ''),
(5, 'admin', '2011-04-24 10:54:28', 'News and Pages akan jadi satu pada versi terbaru', '<p>ini baru terfikir oleh saya selaku admin & developer bahwa keduannya memiliki karakteristik yang sama yaitu menampilkan text barita / informasi yang kita ketik ini ditunjukan adanya header / title & isi / content, hal ini dapat disatukan dengan menggunakan pemisah type baik itu pages / news. Nah news disini saya ganti menjadi postÂ agar tidak salah kaprah serta memudahkan penyebutannya, lalu bagaimana managemennya yg jelas tidak jauh beda dengan versi versi sebelumnnya.</p>\r\n<p>Â </p>\r\n<p>Pengujian & penerapan ini membuat database tidak memakan banyak space nama & hal ini membuat semakin mudahnya dalam hal backup.</p>\r\n<p>untuk sisi load code cukup mudah hanya dengan memanggil function yang saya sediakan nantinya.</p>\r\n<p>mudah mudahan hal ini cepat cepat terlaksana & selesai pada waktunya. amiin</p>\r\n<p>Â </p>\r\n<p>cukup sekian artikel yang saya buat karna saya tidak terlalu pandai dalam membuat sebuah karya tulisan..dan saya menghimbau kepada teman2 agar mendukung kami & para developer cmsid terimakasih..</p>', '0', 17, 53, 'bersatu,terbaru,versi,cmsid,pages,news,post', 'news-and-pages-akan-jadi-satu-pada-versi-terbaru', 'post', 1, '20130117105428@Untitled-2_copy.JPG', '', 1, '', ''),
(36, 'admin', '2011-09-23 08:31:20', 'release 2.1.0 beta 2 perbaikan feature cmsid', '<p>alhamdulillah dengan rahmat allah saya sebagai developer cmsid masih bisa meluangkan waktu untuk menulis artikel tentang releasenya cms id versi 2.1.0 beta 2, yang sebelumnya kami selaku development cmsid telah meluncurkan cmsid versi 2.1 beta pertama.</p>\r\n<p>insyaallah dengan hadirnya versi 2.1.0 beta 2 ini dapat memperbaiki feature - feature yang belum sempat dirampungkan di cmsid id versi 2.1.0 beta pertama.</p>\r\n<p>apa saja yang telah mengalami perombakan & perbaikan ialah:</p>\r\n<p>1. seo</p>\r\n<p>pada fix finis ini ditambahkan plugin seo demi melancarkan management seonya.</p>\r\n<p>2. auto update</p>\r\n<p>fixnya adalah perbaikan detect jika tersedia versi beta</p>\r\n<p>Â </p>\r\n<p>sebenarnya masih banyak lagi fiature feature yang ditambahkan & diperbaiki, listnya bisa dilihat pada fileÂ list-update-2.1.0.txt yang disertakan pada paket download.</p>\r\n<p>Â </p>\r\n<p>salam id</p>\r\n<p>by eko</p>\r\n<p>Â </p>', 'admin@cmsid.org', 18, 571, '2.1,beta', 'release-2-1-beta-2-perbaikan-feature-cmsid', 'post', 1, 'logo.ID5-04.jpg', '', 0, '', ''),
(6, 'admin', '2011-04-24 15:56:05', 'preview design baru untuk cms id versi terbaru yaitu versi 2.1', '<p>versi baru design baru.., ya tema mungkin anda tidak sabar dengan kedatangan versi baru yang akan kami release berikutnya.</p>\r\n<p>dan tak usah lamalama lagi berikut saya kasih liat preview versi terbaru cms id yang mengusung jQuery.</p>\r\n<p>berikut link preview lebih lengkapnya <a href="http://www.flickr.com/photos/58290089@N03/5939398637/" target="_self">http://www.flickr.com/photos/58290089@N03/5939398637/Â </a></p>\r\n<p>silahkan dinikmati...</p>\r\n<p>Â </p>\r\n<p>versi terbaru yang mengusung jQuery atau yang lebih dikenal bahasa pemrograman javascript ini sangat mudah anda gunakan untuk pengaplikasian cms id , apalagi banyak sekali dukungan plugin2 untuk jQuery tsb, diantara plugin2 jQuery tsb yang saya gunakan diantarannya ada,..</p>\r\n<p><strong>drag ndrop</strong> yang memungkinkan anda memindai panel2 sesuka anda</p>\r\n<p><strong>tabs </strong>yang meungkinkan anda meringkas konten dengan hanya menggunakan menu tab</p>\r\n<p><strong>uniform</strong> hal ini memungkinkan anda membuat menarik tampilan form anda</p>\r\n<p><strong>wkrte</strong> adalah text editor terbaru untuk cms id yang dimofikasi untuk lebih memudahkan menulis text naskah favorite anda, tp jangan khawatir karna jika anda tidak suka dengan text editor default yang kami sediakan anda bisa memodifikasi dari tinyeditor atau text editor2 yang anda sukai atau anggap favorite dan masih banyak lagiÂ </p>\r\n<p><img src="http://farm7.static.flickr.com/6014/5939398637_888efbe077_b.jpg" alt="" width="100%" /></p>\r\n<p>salam id by</p>\r\n<p>eko</p>\r\n<p>pendiri cmsid</p>', '0', 17, 34, 'versi baru,cmsid,2.1', 'preview-design-baru-untuk-cms-id-versi-terbaru-yaitu-versi-2-1', 'post', 1, '20120605032444@Desert.jpg', '', 1, 'adad', 'fdasf sddafsf'),
(35, 'admin', '2011-09-23 10:42:17', 'fitur-fitur yang paling menarik pada versi 2.1 (butterfly) yang patut anda ketahui', '<p>hallo teman teman, kali ini saya akan mengulas fitur - fitur yang kemungkinan besar akan diboyong ke versi 2.1 stable nantinya.</p>\r\n<p>oya gimana pendapat u tentang cmsid versi 2.1 beta yang baru - baru ini direlease. pasti udah kebayang khan..? bagaimana & seperti apa nantinya versi 2.1 stablenya..</p>\r\n<p>kami pihak developer berusaha semaksimal mungkin dan semampu kami membuat sebuah cms yang memiliki cita guna & kebutuhan yang lebih baik dan mampuni baik itu disegi performa maupun pernggunaan / user frendly.</p>\r\n<p>baik tema kali ini saya akan membahas apa saja sich fitur - fitur yang bisa menarik anda mencicipi versi stable nantinya..?</p>\r\n<p><strong>1. seo</strong></p>\r\n<p>seo adalah salah satu yang sangat - sangat didambahakan oleh setiap cms / web maupun blog manapun, karna dari sinilah kami mencoba mengembangkan sebuah plugins yang mana plugin ini dapat menciptakan permalink sesuai dengan keinginan anda.</p>\r\n<p>dengan plugin ini maka secara otomatis link seo terbentuk, anda cukup melakukan klik & klik saja pada link manager.</p>\r\n<p>ini berbeda dengan seo cmsid versi sebelumnya yang mana diharuskan mengedit file .htaccess demi mewujutkan permalink yang sesuai dengan keinginan anda.</p>\r\n<p><strong>2. privacy</strong></p>\r\n<p>ini adalah sebuah feature yang dapat membantu anda menangani management perubahan home screen anda baik itu disini privacy account maupun maintenaince, dengan kata lain jika halaman website sedang mengalami perombakan maka system akan memberi tahu melalui message home screen. jika website anda tidak menerima registration acoount makan anda cukup menonaktifkan account registration menjadi none / disable, dan masih bayak lagi privacy lainnya.</p>\r\n<p><strong>3. backup</strong></p>\r\n<p>fitur ini dapat membantu anda membackup database maupun file web secara mudah dan simple, fiture ini adalah hasil pengembangan dari versi - versi sebelumnya</p>\r\n<p><strong>4. plugin</strong></p>\r\n<p>fitur ini adalah fitur baru yang diterapkan pertama kali pada versi 2.1.</p>\r\n<p>pada fitur ini anda dapat memenage & editing plugin baik yang aktiv maupun yang non aktif.</p>\r\n<p>Â </p>\r\n<p>Â </p>\r\n<p>trimakasih itu adalah sebagian fitur - fitur yang menarik pada versi 2.1, masih banyak fitur - fitur lainnya yang patut anda coba pada versi 2.1 stable yang kana datang</p>\r\n<p>Â </p>\r\n<p>trimkasih by</p>\r\n<p>eko</p>', 'admin@cmsid.org', 17, 78, 'cmsid,fitur,2.1', 'fitur-fitur-yang-paling-menarik-pada-versi-2-1-butterfly-yang-patut-anda-ketahui', 'post', 1, '20120920024419@Mie-Goreng.jpg', '', 1, '', ''),
(7, 'admin', '2011-04-24 10:55:14', 'fitur fitur dan kelebihan yang diusung cms id versi terbaru', '<p>pertama tama izinkan saya untuk mengenalkan versi baru cmsid.Â <br>\r\n</p>\r\n\r\n<p>Belum terbayang atau sudah terbayangkah anda dengan cmsidÂ </p>\r\n\r\n<p>versi terbaru ini, apasaja fiturnya, apa lebih mudah apa lebih</p>\r\n\r\n<p>susah,..</p>\r\n\r\n<p>jawabannya adalah banyak sekali keungulan yang diusung di versi</p>\r\n\r\n<p>terbaru ini diantaranya.</p>\r\n\r\n\r\n<p>1. load query semakin simple.</p>\r\n\r\n<p>misal jika kita ingin meload suatu database anda cukup menggunkan</p>\r\n\r\n<p>library yang sudah disiapkan.</p>\r\n\r\n\r\n<p>berikut load variable default table</p>\r\n\r\n\r\n<blockquote>\r\nvar $old_tables = array( ''users_data'', ''users'', ''sidebar_act'', ''sidebar'', ''sensor'', ''post_topic'', ''post_comment_replay'', ''post_comment'', ''posted_ip'', ''post'', ''plugins'', ''options'', ''menu_user'', ''menu_sub'',''menu'' );<br>\r\n\r\n</blockquote>\r\n\r\n<p>pertamakali anda harus tau function loadnya</p>\r\n\r\n\r\n\r\n<blockquote>\r\nglobal $iw,$db;<br>\r\n\r\n<p>a. $db->select($table,$where=false,$order=false);</p>\r\n\r\n<p>b. $db->insert($table,$data);</p>\r\n\r\n<p>c. $db->update($table,$data,$where=false);</p>\r\n\r\n<p>d. $db->delete($table,$where);</p>\r\n\r\n<p>e. $db->replace($table,$data);</p>\r\n\r\n</blockquote>\r\n\r\n\r\n<p>catatan:</p>\r\n\r\n<p>variabel $table : nama table yang digunakan, misal table ''dbprefix_post'' cukup dipanggil dengan ''post''</p>\r\n\r\n<p>variabel $where : harus array,karena bernilai false tidak diisi tidak apa apa</p>\r\n\r\n<p>variabel $order : untuk variabel order anda bisa mendescripsikan seperti biasa, bernilai false</p>\r\n\r\n<p>variabel $data Â : variable yang akan diinsertkan atau di update</p>\r\n\r\n\r\n<p>contoh:</p>\r\n\r\n<p>kita mau melist table posting scriptnya:</p>\r\n\r\n\r\n\r\n<blockquote>\r\nglobal $iw,$db;<br>\r\n\r\n<p>$db=new mysql; // ini tidak ditulis tidak apa apa, karena system mengglobalkan variablenya</p>\r\n\r\n<p>$db->add_table(''post''); // ini digunakan jika table yang ada panggil tidak ada pada daftar array default</p>\r\n\r\n\r\n<p>$where = array(''id''=>23,''type''=>''post'');</p>\r\n\r\n<p>$order = ''id DESC LIMIT 10'';</p>\r\n\r\n\r\n<p>$sql = $db->select(''post'',$where,$order);</p>\r\n\r\n<p>while($row = $db->fetch_array($sql)){</p>\r\n\r\n\r\n<p>echo $row[''title''];</p>\r\n\r\n\r\n<p>}</p>\r\n\r\n</blockquote>\r\n\r\n<p>trus bagaimana klo pemanggilan querynya seperti biasa aja, apa masih bisa?<br>\r\n jawabannya masih bisa:<br>\r\n scriptnya sbr:</p>\r\n\r\n\r\n<blockquote>\r\nglobal $iw,$db;<br>\r\n\r\n<p>$db->query(''SELECT * FROM ''.$iw->pre.''post WHERE id=23 AND type="post" ORDER BY id DESC LIMIT 10 '');</p>\r\n\r\n<p>while($row = $db->fetch_array($sql)){</p>\r\n\r\n\r\n<p>echo $row[''title''];</p>\r\n\r\n\r\n<p>}</p>\r\n\r\n</blockquote>\r\n\r\n\r\n<p>2.struktur direktori cmsid</p>\r\n\r\n\r\n\r\n<blockquote>\r\niadmin/<br>\r\n\r\n<p>-manage/</p>\r\n\r\n<p>--direktor system</p>\r\n\r\n<p>---->manage.php</p>\r\n\r\n<p>---->inc.php</p>\r\n\r\n<p>-templates</p>\r\n\r\n\r\n<p>icontent/</p>\r\n\r\n<p>-applications/</p>\r\n\r\n<p>--direktor aplikasi</p>\r\n\r\n<p>---->manage.php</p>\r\n\r\n<p>---->inc.phpÂ </p>\r\n\r\n<p>---->load.name load .php (*) file ini yang akan di load dengan link ''irequest.php?load=(nama load)&app=(nama apps)''</p>\r\n\r\n\r\n<p>-images/</p>\r\n\r\n<p>-javascripts/</p>\r\n\r\n<p>-plugins/</p>\r\n\r\n<p>--berisi plugin-plugin, bisa berupa direktori atau berupa file</p>\r\n\r\n\r\n<p>-stylesheet/</p>\r\n\r\n<p>-themes/</p>\r\n\r\n<p>--direktori themes</p>\r\n\r\n\r\n<p>-uploads/</p>\r\n\r\n\r\n<p>ilibs/</p>\r\n\r\n<p>-(*) library pendukung</p>\r\n\r\n\r\n<p>temp/</p>\r\n\r\n<p>-(*) tempat penyimpanan sementara</p>\r\n\r\n\r\n<p>iconfig.php (*) pengaturan koneksi kedatabase dan lain-lain</p>\r\n\r\n<p>irequest.php (*) load request file apps</p>\r\n\r\n<p>index.php (*) indexing cms</p>\r\n\r\n\r\n</blockquote>\r\n\r\n\r\n<p>3.halaman login, registrasi tersendiri</p>\r\n\r\n<p>4.cpanel management lebih memudahkan dalam berinstraksi seperti yang bisa anda lihatÂ </p>\r\n\r\n<p>pada link: http://www.cmsid.org/article/preview-design-baru-untuk-cms-id-versi-terbaru-yaitu-versi-2-1.html</p>\r\n\r\n\r\n<p>5.table news & page dijadikan satu ''post'' dengan type sebagai pembedanyaÂ </p>\r\n\r\n<p>6.pengaturan web lebih mudah dengan disediakannya panel panel sebagai berikut:</p>\r\n\r\n<p>a. panel option</p>\r\n\r\n<p>1.general: mengatur meta web seperti title,deskription,keyword, email bahkan zona waktu atau timzone</p>\r\n\r\n<p>2.privacy: pengaturan pribadi content, seperti author name, account registration,web status, admin message, update system Â (belum tersedia untuk versi beta),</p>\r\n\r\n<p>timout (batas waktu web logout bisa tidak ada kativitas sama sekali pada admin atau content)</p>\r\n\r\n<p>3.permalinks: mengatur bentuk link content (belum tersedia untuk versi beta), dan lain lain.</p>\r\n\r\n<p>b. panel users</p>\r\n\r\n<p>untuk mengatur & memanage user account</p>\r\n\r\n<p>c. panel backup</p>\r\n\r\n<p>untuk membeckup database maupun file website</p>\r\n\r\n<p>d. panel layout</p>\r\n\r\n<p>untukn mengatur & mengedit themes</p>\r\n\r\n<p>e. panel sidebar</p>\r\n\r\n<p>untuk mengatur posisi, action, block dengan mudah, sekarang sudah dipermudah dengan icon icon action</p>\r\n\r\n<p>f. panel menus</p>\r\n\r\n<p>untuk mengatur menu yang ditampilkan di web (dalam penyempurnaan)</p>\r\n\r\n<p>g. media /file web manager</p>\r\n\r\n<p>untuk memonitoring file dan direktori web Â (dalam penyempurnaan)</p>\r\n\r\n<p>h. panel plugins</p>\r\n\r\n<p>untuk memange plugin-plugin dengan mudah, anda bisa layaknya plugin-plugin pada cms wordpress</p>\r\n\r\n\r\n<p>7.application manager</p>\r\n\r\n<p>untuk memanage aplikasi seperti postingan, contact message dll</p>\r\n\r\n\r\n\r\n<p>itu adalah beberapa kelebihan atau fitur yang diusing pada versi terbaru, kami developer tidak luput dari kesalahan atau humman error</p>\r\n\r\n<p>maka dari itu kami memerlukan sedikit dukungan anda yang sekirannya dapat menjadikan cms ini sebagai cms yang lebih baik lagi</p>\r\n\r\n\r\n<p>trimakasih..</p>\r\n\r\n\r\n<p>salam id</p>\r\n\r\n\r\n<p>by eko</p>\r\n\r\n\r\n<p>dev & pendiri id</p>', '0', 17, 208, 'fitur,new version,cmsid', 'fitur-fitur-dan-kelebihan-yang-diusung-cms-id-versi-terbaru', 'post', 1, '20130117105514@DSC_0038.JPG', '', 1, '', ''),
(34, 'admin', '2011-09-23 10:53:33', 'cms id versi 2.1 beta relase dengan code name butterfly', '<p>alhamdulillah akhirnya rampung juga versi 2.1 walaupun masih beta.</p>\r\n<p>baik trimakasih kepada temen temen yang sudah mendukung kami selaku developer cmsid, telah sekian lama menunggu versi terbaru dari cmsid, akhirnya release juga.. hhmm alhamdulillah sedikit lega nich..:).</p>\r\n<p>saya pernah menulis artikel bahwa versi terbaru cmsid akan dirilis di bulan agustus 2011 bertepatan dengan bulan suci ramadhan.., ya kini versi 2.1 bisa anda nikmati tapi inibaru untuk versi betanya, jadi bagi anda yang tidak sabar ingin mencobanya silahkan download pada halaman download.,</p>\r\n<p>baik saya tidak akan berpanjang lebar, yang menarik disini ialah kami menambahkan codename untuk versi 2.1 dengan code name butterfly.</p>\r\n<p>oke dech itu sedikit ulasan dari release versi terbaru.</p>\r\n<p>trus cara installnya masih sama ngk..??</p>\r\n<p>jawab: masih sama silahkan anda baca file readme.txt yang saya sertakan didalamnnya.</p>\r\n<p>berikut video installasi cmsid</p>\r\n<p>installasi menggunakan appserver</p>\r\n<p>\r\n<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="100%" height="400" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0">\r\n<param name="src" value="https://www.youtube.com/v/_-5ov-QLMh0" /><embed type="application/x-shockwave-flash" width="100%" height="400" src="https://www.youtube.com/v/_-5ov-QLMh0"></embed>\r\n</object>\r\n</p>\r\n<p>Â </p>\r\n<p>installasi menggunakan xampp</p>\r\n<p>Â </p>\r\n<p>\r\n<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="100%" height="400" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0">\r\n<param name="src" value="https://www.youtube.com/v/Ux0VddaFx3U" /><embed type="application/x-shockwave-flash" width="100%" height="400" src="https://www.youtube.com/v/Ux0VddaFx3U"></embed>\r\n</object>\r\n</p>\r\n<p>apabila ada komentar atausaran,. kami akan menampung untuk dijadikan bahan pertimbangan kami yang mungkin dapat membantu cms id lebih baik lagi.</p>\r\n<p>Â </p>\r\n<p>salam id</p>\r\n<p>eko</p>', 'admin@cmsid.org', 18, 22, 'release,2.1,beta', 'cms-id-versi-2-1-beta-relase-dengan-code-name-butterfly', 'post', 1, '20130117105333@Sales.png', '', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `iw_post_comment`
--

CREATE TABLE IF NOT EXISTS `iw_post_comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text NOT NULL,
  `author` varchar(30) NOT NULL,
  `email` varchar(90) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time` int(20) NOT NULL,
  `post_id` int(11) NOT NULL DEFAULT '0',
  `comment_parent` int(11) NOT NULL,
  `approved` int(1) NOT NULL DEFAULT '1',
  `user_id` varchar(80) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `iw_post_comment`
--

INSERT INTO `iw_post_comment` (`comment_id`, `comment`, `author`, `email`, `date`, `time`, `post_id`, `comment_parent`, `approved`, `user_id`) VALUES
(52, 'asdasda', 'Eko Azza', 'admin@cmsid.org', '2013-01-16 14:59:12', 1358348352, 35, 37, 1, 'admin'),
(25, 'test komentar ke dua', 'Demos', 'admin@demo.com', '2012-03-13 23:40:33', 1331656833, 36, 0, 1, 'admin'),
(41, 'fasfa asf asa af ', 'Eko Azza', 'admin@cmsid.org', '2013-01-16 05:53:47', 1358315627, 36, 25, 1, 'admin'),
(40, 'adasdasd awsdas aasasd', 'Eko Azza', 'admin@cmsid.org', '2013-01-16 05:50:12', 1358315412, 36, 25, 1, 'admin'),
(48, 'efasfa afasf asfas', 'Eko Azza', 'admin@cmsid.org', '2013-01-16 14:47:41', 1358347661, 35, 37, 1, 'admin'),
(37, 'afdad', 'Eko Azza', 'admin@cmsid.org', '2013-01-16 03:36:53', 1358307413, 35, 0, 1, 'admin'),
(47, 'asdsdfs  fsfsfsd', 'Eko Azza', 'admin@cmsid.org', '2013-01-16 14:44:22', 1358347462, 35, 37, 1, 'admin'),
(39, 'asdasda sda asd', 'Eko Azza', 'admin@cmsid.org', '2013-01-16 05:49:40', 1358315380, 36, 25, 1, 'admin'),
(53, 'asdasd', 'Eko Azza', 'admin@cmsid.org', '2013-01-16 14:59:14', 1358348354, 35, 37, 1, 'admin'),
(49, 'sdaa', 'Eko Azza', 'admin@cmsid.org', '2013-01-16 14:59:06', 1358348346, 35, 37, 1, 'admin'),
(50, 'asdasd', 'Eko Azza', 'admin@cmsid.org', '2013-01-16 14:59:08', 1358348348, 35, 37, 1, 'admin'),
(51, 'asdasda', 'Eko Azza', 'admin@cmsid.org', '2013-01-16 14:59:10', 1358348350, 35, 37, 1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `iw_post_topic`
--

CREATE TABLE IF NOT EXISTS `iw_post_topic` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `topic` varchar(100) NOT NULL,
  `desc` text NOT NULL,
  `public` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `iw_post_topic`
--

INSERT INTO `iw_post_topic` (`id`, `topic`, `desc`, `public`, `status`) VALUES
(4, 'Komputer dan Internet', 'Rublik berita seputar komputer dan internet yang sedang berlangsung', 1, 1),
(2, 'Tip dan Trik', 'Rublik berita seputar tips dan trik dari kontent cmsid', 1, 1),
(17, 'Feature', 'Rublik berita seputar feature feature yang ada pada cmsid', 1, 1),
(18, 'Release', 'Rublik berita seputar perilisan cmsid', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `iw_stat_browse`
--

CREATE TABLE IF NOT EXISTS `iw_stat_browse` (
  `title` varchar(255) NOT NULL DEFAULT '',
  `option` text NOT NULL,
  `hits` text NOT NULL,
  PRIMARY KEY (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `iw_stat_browse`
--

INSERT INTO `iw_stat_browse` (`title`, `option`, `hits`) VALUES
('browser', 'Opera#Mozilla Firefox#Galeon#Mozilla#MyIE#Lynx#Netscape#Konqueror#SearchBot#Internet Explorer 6#Internet Explorer 7#Internet Explorer 8#Internet Explorer 9#Internet Explorer 10#Other#', '0#12#0#124#0#0#0#0#0#0#0#0#0#0#0#'),
('os', 'Windows#Mac#Linux#FreeBSD#SunOS#IRIX#BeOS#OS/2#AIX#Other#', '136#0#0#0#0#0#0#0#0#0#'),
('day', 'Minggu#Senin#Selasa#Rabu#Kamis#Jumat#Sabtu#', '16#25#23#17#32#12#11#'),
('month', 'Januari#Februari#Maret#April#Mei#Juni#Juli#Agustus#September#Oktober#November#Desember#', '90#3#0#0#0#0#0#0#0#0#1#42#'),
('clock', '0:00 - 0:59#1:00 - 1:59#2:00 - 2:59#3:00 - 3:59#4:00 - 4:59#5:00 - 5:59#6:00 - 6:59#7:00 - 7:59#8:00 - 8:59#9:00 - 9:59#10:00 - 10:59#11:00 - 11:59#12:00 - 12:59#13:00 - 13:59#14:00 - 14:59#15:00 - 15:59#16:00 - 16:59#17:00 - 17:59#18:00 - 18:59#19:00 - 19:59#20:00 - 20:59#21:00 - 21:59#22:00 - 22:59#23:00 - 23:59#', '7#4#5#5#7#3#3#23#14#5#6#6#5#5#10#14#1#2#1#2#0#3#3#2#'),
('country', '#', '1#');

-- --------------------------------------------------------

--
-- Table structure for table `iw_stat_count`
--

CREATE TABLE IF NOT EXISTS `iw_stat_count` (
  `id` tinyint(11) NOT NULL AUTO_INCREMENT,
  `ip` text NOT NULL,
  `counter` int(11) NOT NULL DEFAULT '0',
  `hits` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `iw_stat_count`
--

INSERT INTO `iw_stat_count` (`id`, `ip`, `counter`, `hits`) VALUES
(1, '::1', 31, 851);

-- --------------------------------------------------------

--
-- Table structure for table `iw_stat_online`
--

CREATE TABLE IF NOT EXISTS `iw_stat_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipproxy` varchar(100) DEFAULT NULL,
  `host` varchar(100) DEFAULT NULL,
  `ipanda` varchar(100) DEFAULT NULL,
  `proxyserver` varchar(100) DEFAULT NULL,
  `timevisit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1283 ;

--
-- Dumping data for table `iw_stat_online`
--

INSERT INTO `iw_stat_online` (`id`, `ipproxy`, `host`, `ipanda`, `proxyserver`, `timevisit`) VALUES
(1282, '::1', 'Azza-PC', '::1', '', 1359720775);

-- --------------------------------------------------------

--
-- Table structure for table `iw_stat_onlineday`
--

CREATE TABLE IF NOT EXISTS `iw_stat_onlineday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipproxy` varchar(100) DEFAULT NULL,
  `host` varchar(100) DEFAULT NULL,
  `ipanda` varchar(100) DEFAULT NULL,
  `proxyserver` varchar(100) DEFAULT NULL,
  `timevisit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=225 ;

--
-- Dumping data for table `iw_stat_onlineday`
--

INSERT INTO `iw_stat_onlineday` (`id`, `ipproxy`, `host`, `ipanda`, `proxyserver`, `timevisit`) VALUES
(224, '::1', 'Azza-PC', '::1', '', 1359720775);

-- --------------------------------------------------------

--
-- Table structure for table `iw_stat_onlinemonth`
--

CREATE TABLE IF NOT EXISTS `iw_stat_onlinemonth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipproxy` varchar(100) DEFAULT NULL,
  `host` varchar(100) DEFAULT NULL,
  `ipanda` varchar(100) DEFAULT NULL,
  `proxyserver` varchar(100) DEFAULT NULL,
  `timevisit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=132 ;

--
-- Dumping data for table `iw_stat_onlinemonth`
--

INSERT INTO `iw_stat_onlinemonth` (`id`, `ipproxy`, `host`, `ipanda`, `proxyserver`, `timevisit`) VALUES
(128, '::1', 'Azza-PC', '::1', '', 1359720775);

-- --------------------------------------------------------

--
-- Table structure for table `iw_stat_urls`
--
-- in use(#29 - File '.\cmsid_22_0_356\iw_stat_urls.MYD' not found (Errcode: 2))
-- Error reading data: (#29 - File '.\cmsid_22_0_356\iw_stat_urls.MYD' not found (Errcode: 2))

-- --------------------------------------------------------

--
-- Table structure for table `iw_users`
--

CREATE TABLE IF NOT EXISTS `iw_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL,
  `user_author` varchar(80) NOT NULL,
  `user_pass` varchar(64) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_sex` enum('p','l') NOT NULL,
  `user_registered` datetime NOT NULL,
  `user_last_update` datetime NOT NULL,
  `user_activation_key` varchar(60) NOT NULL,
  `user_level` varchar(25) NOT NULL DEFAULT 'user',
  `user_url` varchar(100) NOT NULL,
  `display_name` smallint(250) NOT NULL,
  `user_country` varchar(64) NOT NULL,
  `user_province` varchar(80) NOT NULL,
  `user_avatar` longtext NOT NULL,
  `user_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `iw_users`
--

INSERT INTO `iw_users` (`ID`, `user_login`, `user_author`, `user_pass`, `user_email`, `user_sex`, `user_registered`, `user_last_update`, `user_activation_key`, `user_level`, `user_url`, `display_name`, `user_country`, `user_province`, `user_avatar`, `user_status`) VALUES
(1, 'admin', 'Eko Azza', '21232f297a57a5a743894a0e4a801fc3', 'admin@cmsid.org', 'l', '2010-03-02 13:09:37', '2013-02-01 12:10:35', '', 'admin', 'http://cmsid.org', 0, 'ID', 'Bandar Lampung', '20130121022320@57ab61ce05cf11e2bf7c22000a1e9ddc_7.jpg', 1),
(2, 'user', 'Example', 'ee11cbb19052e40b07aac0ca060c23ee', 'user@demo.com', 'l', '2010-08-04 09:06:13', '2013-01-13 02:47:50', '', 'user', '', 0, 'ID', 'Bandar Lampung', '', 1),
(14, 'u9', 'u9', '81dc9bdb52d04dc20036dbd8313ed055', 'u9@user.com', 'p', '2013-01-20 00:46:02', '2013-01-22 06:03:27', '', 'user', '', 0, 'ID', 'Bandar Lampung', '20130122060327@Picture0005.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `widget_menu`
--

CREATE TABLE IF NOT EXISTS `widget_menu` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `class` varchar(255) NOT NULL DEFAULT '',
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `group_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `widget_menu`
--

INSERT INTO `widget_menu` (`id`, `parent_id`, `title`, `url`, `class`, `position`, `group_id`) VALUES
(8, 0, 'Home', './', 'home', 1, 1),
(9, 0, 'Gallery', './gallery.html', '', 2, 1),
(12, 0, 'Settings', './setting.html', '', 4, 1),
(17, 0, 'Contact', '#', '', 2, 8),
(16, 0, 'Home', './', '', 1, 8),
(18, 0, 'Page Templates', '#', '', 3, 8),
(19, 18, 'Page Width', '#', '', 1, 8),
(20, 18, 'Page Full', '#', '', 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `widget_menu_group`
--

CREATE TABLE IF NOT EXISTS `widget_menu_group` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `widget_menu_group`
--

INSERT INTO `widget_menu_group` (`id`, `title`) VALUES
(1, 'Menu Utama'),
(8, 'Menu Header');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
