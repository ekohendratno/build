-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2013 at 04:15 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cmsid_22_0_358`
--

-- --------------------------------------------------------

--
-- Table structure for table `iw_menu`
--

DROP TABLE IF EXISTS `iw_menu`;
CREATE TABLE IF NOT EXISTS `iw_menu` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `class` varchar(255) NOT NULL DEFAULT '',
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `group_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `iw_menu`
--

INSERT INTO `iw_menu` (`id`, `parent_id`, `title`, `url`, `class`, `position`, `group_id`) VALUES
(8, 0, 'Home', './', 'home', 1, 1),
(9, 0, 'Gallery', '?com=gallery', '', 2, 1),
(12, 0, 'Settings', '?com=setting', '', 3, 1),
(33, 0, 'Home', '', '', 1, 8),
(34, 0, 'Hubungi Kami', '', '', 3, 8),
(35, 0, 'Dukung Kami', '', '', 4, 8),
(41, 0, 'Demo Halaman', '', '', 2, 8),
(42, 41, 'Full Page', '#', '', 1, 8),
(43, 41, 'Single Page', '#', '', 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `iw_menu_group`
--

DROP TABLE IF EXISTS `iw_menu_group`;
CREATE TABLE IF NOT EXISTS `iw_menu_group` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `iw_menu_group`
--

INSERT INTO `iw_menu_group` (`id`, `title`) VALUES
(1, 'Menu Utama'),
(8, 'Menu Header');

-- --------------------------------------------------------

--
-- Table structure for table `iw_options`
--

DROP TABLE IF EXISTS `iw_options`;
CREATE TABLE IF NOT EXISTS `iw_options` (
  `option_name` varchar(68) NOT NULL,
  `option_value` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `iw_options`
--

INSERT INTO `iw_options` (`option_name`, `option_value`) VALUES
('template', 'portal'),
('sitename', 'CMS ID | Content Management System Indonesia'),
('sitedescription', 'Keterangan dari website'),
('sitekeywords', 'keyword website'),
('admin_email', 'id.hpaherba@yahoo.co.id'),
('site_public', '1'),
('site_charset', 'UTF-8'),
('siteurl', 'http://localhost/cmsid/build/0.3.58'),
('active_plugins', '{"codemirror/codemirror.php":"1","timer.php":"0","activity-records.php":"1","activity/activity.php":"1","disk-memory-usage.php":"1"}'),
('siteslogan', 'slogan website'),
('avatar_default', 'mystery'),
('html_type', 'text/html'),
('frontpage', 'post'),
('menu-action', '[''aksi'':{''posts'':{''title'':''Post'',''link'':''?action=post''},''pages'':{''title'':''Pages'',''link'':''?action=pages''}}]'),
('timezone', 'Asia/Jakarta'),
('site_copyright', '2012 | CMS ID'),
('recent_reg_limit', '30'),
('referal_limit', '10'),
('feed-news', '{"news_feeds":{"News Feed Local":"http://localhost/cmsid/server/2.1.4/rss.xml"},"display":{"desc":0,"author":0,"date":0,"limit":10}}'),
('datetime_format', 'Y/m/d'),
('avatar_default', 'mystery'),
('author', 'admin'),
('account_registration', '1'),
('text_editor', ''),
('disk_limit', '100'),
('post_comment', '1'),
('rewrite', 'advance'),
('body_layout', 'left'),
('dashboard_widget', '{"normal":"dashboard_update_info,dashboard_recent_registration,disk_memory_overview,dashboard_feed_news,dashboard_refering,","side":"dashboard_quick_post,activity_records,"}'),
('use_smilies', '1'),
('date_format', 'F j, Y'),
('security_pip', '[{"file":"comment_on_post","ip":"::1","time":13604101830}]'),
('avatar_type', 'computer'),
('image_allaw', '{"image\\/png":".png","image\\/x-png":".png","image\\/gif":".gif","image\\/jpeg":".jpg","image\\/pjpeg":".jpg"}'),
('file_allaw', '["txt","csv","htm","html","xml","css","doc","xls","rtf","ppt","pdf","swf","flv","avi","wmv","mov","jpg","jpeg","gif","png"]'),
('header-notif-x', '1'),
('account_registration', '0');

-- --------------------------------------------------------

--
-- Table structure for table `iw_post`
--

DROP TABLE IF EXISTS `iw_post`;
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
(2, 'admin', '2011-04-24 00:43:09', 'Abouts', '<p>ID(CMS) dikembangkan bulan april 2010 didirikan oleh Eko.</p><p>awal mulanya cmsid dikembangkan dengan dual language, karena keterbatasan coding dan demi meringkas cmsid menjadi lebih mudah digunakan, maka untuk sementar pengembangan dual language dihentikan sementara.</p><p><br>ID(CMS) sendiri diadobsi dari bahasa pemrograman web yang sederhana, insyaallah interfacenya mudah difahami dengan cepat.</p><p>CMS ini dikembangkan sebagai bahan pembelajaran kita bersama sama</p><p>Tujuan dari Kami yaitu:</p><p>1. memudahkan pemakaian.</p><p>2. membantu anda (pengguna) untuk membuat suatu website</p><p>3. menjadi media opensource yang diakui</p><p>4. media belajar bersama</p><p>5. dapat digunakan sesuai kebutuhan</p><p>Ãƒâ€šÃ‚Â </p><p>Semoga cmsid menjadi media menuangkan ide dan kreativitas bersama</p>', '0', 0, 0, '', 'abouts', 'page', 1, '', '', 1, '', ''),
(3, 'admin', '2011-08-24 14:12:39', 'Varian terbaru cms id sedang dikembangkan', '<p>Mungkin anda sedang bertanya tanya apa maksud judul diatas...</p>\r\n<p>Baiklah saya akan jelaskan maksudnya iyalah kini cms id sedang mengembangkan verian terbarunya yg powerfull ini juga berkat dari refrensi2 cms yg ada..</p>\r\n<p>Varian ini diklaim lebih mutahir dari pada versi-versi cms id sebelumnya, tidak akan saya sebutkan verian terbaru ini dikembangkan untuk cms id versi berapa, yg jelas verian ini lebih simple, mudah tapi tidak mudah untuk ditaklukkan... hehehe kyx penjinak aja...:), lebih nyaman digunkan, lebih enteng, content management tersendiri seperti themes, plugin dan application.</p>\r\n<p>ok saya tidak akan terburu buru untuk mereleasenya... karna saya ingin melihat respon dari anda masing2 pecinta cms id, baik tiu sebagai penyumbang ide, modul, maupun sempat bertanya..</p>\r\n<p>cms id varian baru ini dikembangkan pada platform yg umum digunakan, seperti</p>\r\n<p>php dan mysql versi standar, maka dari itu saya selaku admin dan pendiri id (cms id) agar anda mengirimkan kritik dan sarannya agar kami bisa lebih maju &amp; sesuai dengan keinginan anda walaupun tak sempurna, dan saya menyarankan agar anda lebih sabar menunggu kehadiran varian baru ini yg diadobsi dari dari cms cms yg pernah dibuat, kalau bisa dibilang sich mirip tapi tak sama :), itulah cms id</p>\r\n<p>&nbsp;</p>\r\n<p>salam id</p>\r\n<p>by eko</p>\r\n<p>&nbsp;</p>', '0', 4, 94, 'varian,baru,cmsid', 'varian-terbaru-cms-id-sedang-dikembangkan', 'post', 1, 'gVl9y3utKo.jpg', '', 1, '', ''),
(5, 'admin', '2011-04-24 10:54:28', 'News and Pages akan jadi satu pada versi terbaru', '<p>ini baru terfikir oleh saya selaku admin & developer bahwa keduannya memiliki karakteristik yang sama yaitu menampilkan text barita / informasi yang kita ketik ini ditunjukan adanya header / title & isi / content, hal ini dapat disatukan dengan menggunakan pemisah type baik itu pages / news. Nah news disini saya ganti menjadi postÃƒâ€šÃ‚Â agar tidak salah kaprah serta memudahkan penyebutannya, lalu bagaimana managemennya yg jelas tidak jauh beda dengan versi versi sebelumnnya.</p>\r\n<p>Ãƒâ€šÃ‚Â </p>\r\n<p>Pengujian & penerapan ini membuat database tidak memakan banyak space nama & hal ini membuat semakin mudahnya dalam hal backup.</p>\r\n<p>untuk sisi load code cukup mudah hanya dengan memanggil function yang saya sediakan nantinya.</p>\r\n<p>mudah mudahan hal ini cepat cepat terlaksana & selesai pada waktunya. amiin</p>\r\n<p>Ãƒâ€šÃ‚Â </p>\r\n<p>cukup sekian artikel yang saya buat karna saya tidak terlalu pandai dalam membuat sebuah karya tulisan..dan saya menghimbau kepada teman2 agar mendukung kami & para developer cmsid terimakasih..</p>', '0', 17, 71, 'bersatu,terbaru,versi,cmsid,pages,news,post', 'news-and-pages-akan-jadi-satu-pada-versi-terbaru', 'post', 1, '20130117105428@Untitled-2_copy.JPG', '', 1, '', ''),
(36, 'admin', '2011-09-23 08:31:20', 'release 2.1.0 beta 2 perbaikan feature cmsid', '<p>alhamdulillah dengan rahmat allah saya sebagai developer cmsid masih bisa meluangkan waktu untuk menulis artikel tentang releasenya cms id versi 2.1.0 beta 2, yang sebelumnya kami selaku development cmsid telah meluncurkan cmsid versi 2.1 beta pertama.</p>\r\n<p>insyaallah dengan hadirnya versi 2.1.0 beta 2 ini dapat memperbaiki feature - feature yang belum sempat dirampungkan di cmsid id versi 2.1.0 beta pertama.</p>\r\n<p>apa saja yang telah mengalami perombakan & perbaikan ialah:</p>\r\n<p>1. seo</p>\r\n<p>pada fix finis ini ditambahkan plugin seo demi melancarkan management seonya.</p>\r\n<p>2. auto update</p>\r\n<p>fixnya adalah perbaikan detect jika tersedia versi beta</p>\r\n<p>Ãƒâ€šÃ‚Â </p>\r\n<p>sebenarnya masih banyak lagi fiature feature yang ditambahkan & diperbaiki, listnya bisa dilihat pada fileÃƒâ€šÃ‚Â list-update-2.1.0.txt yang disertakan pada paket download.</p>\r\n<p>Ãƒâ€šÃ‚Â </p>\r\n<p>salam id</p>\r\n<p>by eko</p>\r\n<p>Ãƒâ€šÃ‚Â </p>', 'admin@cmsid.org', 18, 571, '2.1,beta', 'release-2-1-beta-2-perbaikan-feature-cmsid', 'post', 0, 'logo.ID5-04.jpg', '', 1, '', ''),
(6, 'admin', '2011-04-24 15:56:05', 'preview design baru untuk cms id versi terbaru yaitu versi 2.1', '<p>versi baru design baru.., ya tema mungkin anda tidak sabar dengan kedatangan versi baru yang akan kami release berikutnya.</p>\r\n<p>dan tak usah lamalama lagi berikut saya kasih liat preview versi terbaru cms id yang mengusung jQuery.</p>\r\n<p>berikut link preview lebih lengkapnya <a href="http://www.flickr.com/photos/58290089@N03/5939398637/" target="_self">http://www.flickr.com/photos/58290089@N03/5939398637/Ãƒâ€šÃ‚Â </a></p>\r\n<p>silahkan dinikmati...</p>\r\n<p>Ãƒâ€šÃ‚Â </p>\r\n<p>versi terbaru yang mengusung jQuery atau yang lebih dikenal bahasa pemrograman javascript ini sangat mudah anda gunakan untuk pengaplikasian cms id , apalagi banyak sekali dukungan plugin2 untuk jQuery tsb, diantara plugin2 jQuery tsb yang saya gunakan diantarannya ada,..</p>\r\n<p><strong>drag ndrop</strong> yang memungkinkan anda memindai panel2 sesuka anda</p>\r\n<p><strong>tabs </strong>yang meungkinkan anda meringkas konten dengan hanya menggunakan menu tab</p>\r\n<p><strong>uniform</strong> hal ini memungkinkan anda membuat menarik tampilan form anda</p>\r\n<p><strong>wkrte</strong> adalah text editor terbaru untuk cms id yang dimofikasi untuk lebih memudahkan menulis text naskah favorite anda, tp jangan khawatir karna jika anda tidak suka dengan text editor default yang kami sediakan anda bisa memodifikasi dari tinyeditor atau text editor2 yang anda sukai atau anggap favorite dan masih banyak lagiÃƒâ€šÃ‚Â </p>\r\n<p><img src="http://farm7.static.flickr.com/6014/5939398637_888efbe077_b.jpg" alt="" width="100%" /></p>\r\n<p>salam id by</p>\r\n<p>eko</p>\r\n<p>pendiri cmsid</p>', '0', 17, 43, 'versi baru,cmsid,2.1', 'preview-design-baru-untuk-cms-id-versi-terbaru-yaitu-versi-2-1', 'post', 1, '20120605032444@Desert.jpg', '', 1, 'adad', 'fdasf sddafsf'),
(35, 'admin', '2011-09-23 10:42:17', 'fitur-fitur yang paling menarik pada versi 2.1 (butterfly) yang patut anda ketahui', '<p>hallo teman teman, kali ini saya akan mengulas fitur - fitur yang kemungkinan besar akan diboyong ke versi 2.1 stable nantinya.</p>\r\n<p>oya gimana pendapat u tentang cmsid versi 2.1 beta yang baru - baru ini direlease. pasti udah kebayang khan..? bagaimana & seperti apa nantinya versi 2.1 stablenya..</p>\r\n<p>kami pihak developer berusaha semaksimal mungkin dan semampu kami membuat sebuah cms yang memiliki cita guna & kebutuhan yang lebih baik dan mampuni baik itu disegi performa maupun pernggunaan / user frendly.</p>\r\n<p>baik tema kali ini saya akan membahas apa saja sich fitur - fitur yang bisa menarik anda mencicipi versi stable nantinya..?</p>\r\n<p><strong>1. seo</strong></p>\r\n<p>seo adalah salah satu yang sangat - sangat didambahakan oleh setiap cms / web maupun blog manapun, karna dari sinilah kami mencoba mengembangkan sebuah plugins yang mana plugin ini dapat menciptakan permalink sesuai dengan keinginan anda.</p>\r\n<p>dengan plugin ini maka secara otomatis link seo terbentuk, anda cukup melakukan klik & klik saja pada link manager.</p>\r\n<p>ini berbeda dengan seo cmsid versi sebelumnya yang mana diharuskan mengedit file .htaccess demi mewujutkan permalink yang sesuai dengan keinginan anda.</p>\r\n<p><strong>2. privacy</strong></p>\r\n<p>ini adalah sebuah feature yang dapat membantu anda menangani management perubahan home screen anda baik itu disini privacy account maupun maintenaince, dengan kata lain jika halaman website sedang mengalami perombakan maka system akan memberi tahu melalui message home screen. jika website anda tidak menerima registration acoount makan anda cukup menonaktifkan account registration menjadi none / disable, dan masih bayak lagi privacy lainnya.</p>\r\n<p><strong>3. backup</strong></p>\r\n<p>fitur ini dapat membantu anda membackup database maupun file web secara mudah dan simple, fiture ini adalah hasil pengembangan dari versi - versi sebelumnya</p>\r\n<p><strong>4. plugin</strong></p>\r\n<p>fitur ini adalah fitur baru yang diterapkan pertama kali pada versi 2.1.</p>\r\n<p>pada fitur ini anda dapat memenage & editing plugin baik yang aktiv maupun yang non aktif.</p>\r\n<p>Ãƒâ€šÃ‚Â </p>\r\n<p>Ãƒâ€šÃ‚Â </p>\r\n<p>trimakasih itu adalah sebagian fitur - fitur yang menarik pada versi 2.1, masih banyak fitur - fitur lainnya yang patut anda coba pada versi 2.1 stable yang kana datang</p>\r\n<p>Ãƒâ€šÃ‚Â </p>\r\n<p>trimkasih by</p>\r\n<p>eko</p>', 'admin@cmsid.org', 17, 152, 'cmsid,fitur,2.1', 'fitur-fitur-yang-paling-menarik-pada-versi-2-1-butterfly-yang-patut-anda-ketahui', 'post', 1, '20120920024419@Mie-Goreng.jpg', '', 1, '', ''),
(7, 'admin', '2011-04-24 10:55:14', 'fitur fitur dan kelebihan yang diusung cms id versi terbaru', '<p>pertama tama izinkan saya untuk mengenalkan versi baru cmsid.Ãƒâ€šÃ‚Â <br>\r\n</p>\r\n\r\n<p>Belum terbayang atau sudah terbayangkah anda dengan cmsidÃƒâ€šÃ‚Â </p>\r\n\r\n<p>versi terbaru ini, apasaja fiturnya, apa lebih mudah apa lebih</p>\r\n\r\n<p>susah,..</p>\r\n\r\n<p>jawabannya adalah banyak sekali keungulan yang diusung di versi</p>\r\n\r\n<p>terbaru ini diantaranya.</p>\r\n\r\n\r\n<p>1. load query semakin simple.</p>\r\n\r\n<p>misal jika kita ingin meload suatu database anda cukup menggunkan</p>\r\n\r\n<p>library yang sudah disiapkan.</p>\r\n\r\n\r\n<p>berikut load variable default table</p>\r\n\r\n\r\n<blockquote>\r\nvar $old_tables = array( ''users_data'', ''users'', ''sidebar_act'', ''sidebar'', ''sensor'', ''post_topic'', ''post_comment_replay'', ''post_comment'', ''posted_ip'', ''post'', ''plugins'', ''options'', ''menu_user'', ''menu_sub'',''menu'' );<br>\r\n\r\n</blockquote>\r\n\r\n<p>pertamakali anda harus tau function loadnya</p>\r\n\r\n\r\n\r\n<blockquote>\r\nglobal $iw,$db;<br>\r\n\r\n<p>a. $db->select($table,$where=false,$order=false);</p>\r\n\r\n<p>b. $db->insert($table,$data);</p>\r\n\r\n<p>c. $db->update($table,$data,$where=false);</p>\r\n\r\n<p>d. $db->delete($table,$where);</p>\r\n\r\n<p>e. $db->replace($table,$data);</p>\r\n\r\n</blockquote>\r\n\r\n\r\n<p>catatan:</p>\r\n\r\n<p>variabel $table : nama table yang digunakan, misal table ''dbprefix_post'' cukup dipanggil dengan ''post''</p>\r\n\r\n<p>variabel $where : harus array,karena bernilai false tidak diisi tidak apa apa</p>\r\n\r\n<p>variabel $order : untuk variabel order anda bisa mendescripsikan seperti biasa, bernilai false</p>\r\n\r\n<p>variabel $data Ãƒâ€šÃ‚Â : variable yang akan diinsertkan atau di update</p>\r\n\r\n\r\n<p>contoh:</p>\r\n\r\n<p>kita mau melist table posting scriptnya:</p>\r\n\r\n\r\n\r\n<blockquote>\r\nglobal $iw,$db;<br>\r\n\r\n<p>$db=new mysql; // ini tidak ditulis tidak apa apa, karena system mengglobalkan variablenya</p>\r\n\r\n<p>$db->add_table(''post''); // ini digunakan jika table yang ada panggil tidak ada pada daftar array default</p>\r\n\r\n\r\n<p>$where = array(''id''=>23,''type''=>''post'');</p>\r\n\r\n<p>$order = ''id DESC LIMIT 10'';</p>\r\n\r\n\r\n<p>$sql = $db->select(''post'',$where,$order);</p>\r\n\r\n<p>while($row = $db->fetch_array($sql)){</p>\r\n\r\n\r\n<p>echo $row[''title''];</p>\r\n\r\n\r\n<p>}</p>\r\n\r\n</blockquote>\r\n\r\n<p>trus bagaimana klo pemanggilan querynya seperti biasa aja, apa masih bisa?<br>\r\n jawabannya masih bisa:<br>\r\n scriptnya sbr:</p>\r\n\r\n\r\n<blockquote>\r\nglobal $iw,$db;<br>\r\n\r\n<p>$db->query(''SELECT * FROM ''.$iw->pre.''post WHERE id=23 AND type="post" ORDER BY id DESC LIMIT 10 '');</p>\r\n\r\n<p>while($row = $db->fetch_array($sql)){</p>\r\n\r\n\r\n<p>echo $row[''title''];</p>\r\n\r\n\r\n<p>}</p>\r\n\r\n</blockquote>\r\n\r\n\r\n<p>2.struktur direktori cmsid</p>\r\n\r\n\r\n\r\n<blockquote>\r\niadmin/<br>\r\n\r\n<p>-manage/</p>\r\n\r\n<p>--direktor system</p>\r\n\r\n<p>---->manage.php</p>\r\n\r\n<p>---->inc.php</p>\r\n\r\n<p>-templates</p>\r\n\r\n\r\n<p>icontent/</p>\r\n\r\n<p>-applications/</p>\r\n\r\n<p>--direktor aplikasi</p>\r\n\r\n<p>---->manage.php</p>\r\n\r\n<p>---->inc.phpÃƒâ€šÃ‚Â </p>\r\n\r\n<p>---->load.name load .php (*) file ini yang akan di load dengan link ''irequest.php?load=(nama load)&app=(nama apps)''</p>\r\n\r\n\r\n<p>-images/</p>\r\n\r\n<p>-javascripts/</p>\r\n\r\n<p>-plugins/</p>\r\n\r\n<p>--berisi plugin-plugin, bisa berupa direktori atau berupa file</p>\r\n\r\n\r\n<p>-stylesheet/</p>\r\n\r\n<p>-themes/</p>\r\n\r\n<p>--direktori themes</p>\r\n\r\n\r\n<p>-uploads/</p>\r\n\r\n\r\n<p>ilibs/</p>\r\n\r\n<p>-(*) library pendukung</p>\r\n\r\n\r\n<p>temp/</p>\r\n\r\n<p>-(*) tempat penyimpanan sementara</p>\r\n\r\n\r\n<p>iconfig.php (*) pengaturan koneksi kedatabase dan lain-lain</p>\r\n\r\n<p>irequest.php (*) load request file apps</p>\r\n\r\n<p>index.php (*) indexing cms</p>\r\n\r\n\r\n</blockquote>\r\n\r\n\r\n<p>3.halaman login, registrasi tersendiri</p>\r\n\r\n<p>4.cpanel management lebih memudahkan dalam berinstraksi seperti yang bisa anda lihatÃƒâ€šÃ‚Â </p>\r\n\r\n<p>pada link: http://www.cmsid.org/article/preview-design-baru-untuk-cms-id-versi-terbaru-yaitu-versi-2-1.html</p>\r\n\r\n\r\n<p>5.table news & page dijadikan satu ''post'' dengan type sebagai pembedanyaÃƒâ€šÃ‚Â </p>\r\n\r\n<p>6.pengaturan web lebih mudah dengan disediakannya panel panel sebagai berikut:</p>\r\n\r\n<p>a. panel option</p>\r\n\r\n<p>1.general: mengatur meta web seperti title,deskription,keyword, email bahkan zona waktu atau timzone</p>\r\n\r\n<p>2.privacy: pengaturan pribadi content, seperti author name, account registration,web status, admin message, update system Ãƒâ€šÃ‚Â (belum tersedia untuk versi beta),</p>\r\n\r\n<p>timout (batas waktu web logout bisa tidak ada kativitas sama sekali pada admin atau content)</p>\r\n\r\n<p>3.permalinks: mengatur bentuk link content (belum tersedia untuk versi beta), dan lain lain.</p>\r\n\r\n<p>b. panel users</p>\r\n\r\n<p>untuk mengatur & memanage user account</p>\r\n\r\n<p>c. panel backup</p>\r\n\r\n<p>untuk membeckup database maupun file website</p>\r\n\r\n<p>d. panel layout</p>\r\n\r\n<p>untukn mengatur & mengedit themes</p>\r\n\r\n<p>e. panel sidebar</p>\r\n\r\n<p>untuk mengatur posisi, action, block dengan mudah, sekarang sudah dipermudah dengan icon icon action</p>\r\n\r\n<p>f. panel menus</p>\r\n\r\n<p>untuk mengatur menu yang ditampilkan di web (dalam penyempurnaan)</p>\r\n\r\n<p>g. media /file web manager</p>\r\n\r\n<p>untuk memonitoring file dan direktori web Ãƒâ€šÃ‚Â (dalam penyempurnaan)</p>\r\n\r\n<p>h. panel plugins</p>\r\n\r\n<p>untuk memange plugin-plugin dengan mudah, anda bisa layaknya plugin-plugin pada cms wordpress</p>\r\n\r\n\r\n<p>7.application manager</p>\r\n\r\n<p>untuk memanage aplikasi seperti postingan, contact message dll</p>\r\n\r\n\r\n\r\n<p>itu adalah beberapa kelebihan atau fitur yang diusing pada versi terbaru, kami developer tidak luput dari kesalahan atau humman error</p>\r\n\r\n<p>maka dari itu kami memerlukan sedikit dukungan anda yang sekirannya dapat menjadikan cms ini sebagai cms yang lebih baik lagi</p>\r\n\r\n\r\n<p>trimakasih..</p>\r\n\r\n\r\n<p>salam id</p>\r\n\r\n\r\n<p>by eko</p>\r\n\r\n\r\n<p>dev & pendiri id</p>', '0', 17, 231, 'fitur,new version,cmsid', 'fitur-fitur-dan-kelebihan-yang-diusung-cms-id-versi-terbaru', 'post', 1, '20130117105514@DSC_0038.JPG', '', 1, '', ''),
(34, 'admin', '2011-09-23 10:53:33', 'cms id versi 2.1 beta relase dengan code name butterfly', '<p>alhamdulillah akhirnya rampung juga versi 2.1 walaupun masih beta.</p>\r\n<p>baik trimakasih kepada temen temen yang sudah mendukung kami selaku developer cmsid, telah sekian lama menunggu versi terbaru dari cmsid, akhirnya release juga.. hhmm alhamdulillah sedikit lega nich..:).</p>\r\n<p>saya pernah menulis artikel bahwa versi terbaru cmsid akan dirilis di bulan agustus 2011 bertepatan dengan bulan suci ramadhan.., ya kini versi 2.1 bisa anda nikmati tapi inibaru untuk versi betanya, jadi bagi anda yang tidak sabar ingin mencobanya silahkan download pada halaman download.,</p>\r\n<p>baik saya tidak akan berpanjang lebar, yang menarik disini ialah kami menambahkan codename untuk versi 2.1 dengan code name butterfly.</p>\r\n<p>oke dech itu sedikit ulasan dari release versi terbaru.</p>\r\n<p>trus cara installnya masih sama ngk..??</p>\r\n<p>jawab: masih sama silahkan anda baca file readme.txt yang saya sertakan didalamnnya.</p>\r\n<p>berikut video installasi cmsid</p>\r\n<p>installasi menggunakan appserver</p>\r\n<p>\r\n<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="100%" height="400" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0">\r\n<param name="src" value="https://www.youtube.com/v/_-5ov-QLMh0" /><embed type="application/x-shockwave-flash" width="100%" height="400" src="https://www.youtube.com/v/_-5ov-QLMh0"></embed>\r\n</object>\r\n</p>\r\n<p>Ãƒâ€šÃ‚Â </p>\r\n<p>installasi menggunakan xampp</p>\r\n<p>Ãƒâ€šÃ‚Â </p>\r\n<p>\r\n<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="100%" height="400" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0">\r\n<param name="src" value="https://www.youtube.com/v/Ux0VddaFx3U" /><embed type="application/x-shockwave-flash" width="100%" height="400" src="https://www.youtube.com/v/Ux0VddaFx3U"></embed>\r\n</object>\r\n</p>\r\n<p>apabila ada komentar atausaran,. kami akan menampung untuk dijadikan bahan pertimbangan kami yang mungkin dapat membantu cms id lebih baik lagi.</p>\r\n<p>Ãƒâ€šÃ‚Â </p>\r\n<p>salam id</p>\r\n<p>eko</p>', 'admin@cmsid.org', 18, 50, 'release,2.1,beta', 'cms-id-versi-2-1-beta-relase-dengan-code-name-butterfly', 'post', 1, '20130117105333@Sales.png', '', 1, '', ''),
(4, 'admin', '0000-00-00 00:00:00', 'Simple Page', '<p>This is an example page. Its different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:</p>\r\n\r\n\r\n<blockquote>Hi there! Im a bike messenger by day, aspiring actor by night, and this is my blog. I live in Los Angeles, have a great dog named Jack, and I like pia coladas. (And gettin caught in the rain.)<br>\r\n</blockquote>\r\n\r\n<p>or something like this:</p>\r\n\r\n\r\n<blockquote>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.<br>\r\n</blockquote>\r\n\r\n<p>As a new user, you should go to <a href="http://localhost/\\">your dashboard</a> to delete this page and create new pages for your content. Have fun!</p>', '', 0, 0, '', 'simple-page', 'page', 1, '', '', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `iw_post_comment`
--

DROP TABLE IF EXISTS `iw_post_comment`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=62 ;

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
(51, 'asdasda', 'Eko Azza', 'admin@cmsid.org', '2013-01-16 14:59:10', 1358348350, 35, 37, 1, 'admin'),
(54, '', '', '', '2013-02-09 11:17:14', 1360408634, 5, 0, 0, ''),
(55, '', '', '', '2013-02-09 11:17:42', 1360408662, 5, 0, 0, ''),
(56, '', 'df', 'df', '2013-02-09 11:17:51', 1360408671, 5, 0, 0, ''),
(57, '', 'df', 'df', '2013-02-09 11:21:41', 1360408901, 5, 0, 0, ''),
(58, '', 'a', 'fafas', '2013-02-09 11:21:49', 1360408909, 5, 0, 0, ''),
(59, 'sdasd asf', 'eko', 'id.hpaherba@yahoo.co.id', '2013-02-09 11:43:03', 1360410183, 5, 0, 1, ''),
(61, 'afsa asf afa f', 'Eko Azza', 'admin@cmsid.org', '2013-02-09 12:15:24', 1360412124, 5, 59, 1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `iw_post_topic`
--

DROP TABLE IF EXISTS `iw_post_topic`;
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
-- Table structure for table `iw_stat_activity`
--

DROP TABLE IF EXISTS `iw_stat_activity`;
CREATE TABLE IF NOT EXISTS `iw_stat_activity` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) NOT NULL,
  `activity_name` varchar(80) NOT NULL,
  `activity_value` longtext NOT NULL,
  `activity_img` text NOT NULL,
  `activity_date` date NOT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `iw_stat_activity`
--

INSERT INTO `iw_stat_activity` (`activity_id`, `user_id`, `activity_name`, `activity_value`, `activity_img`, `activity_date`) VALUES
(2, 'admin', 'manager_options', '[{"activity":"mengubah settingan general option","time":1360672151,"clock":"12:29:11"}]', 'setting', '2013-02-12'),
(3, 'admin', 'manager_plugins', '[{"activity":"memperbaharui plugin codemirror/codemirror.php menjadi 1","time":1360672216,"clock":"12:30:16"},{"activity":"memperbaharui plugin disk-memory-usage.php menjadi 1","time":1360693368,"clock":"18:22:48"}]', 'plugin', '2013-02-12'),
(4, 'admin', 'post', '[{"activity":"memperbaharui post 4","time":1360798069,"clock":"23:27:49"},{"activity":"menyetujui status post 36 menjadi 1","time":1360798372,"clock":"23:32:52"}]', 'post', '2013-02-13'),
(5, 'admin', 'manager_plugins', '[{"activity":"memperbaharui plugin activity/activity.php menjadi 0","time":1360836950,"clock":"10:15:50"},{"activity":"memperbaharui plugin activity/activity.php menjadi 0","time":1360837035,"clock":"10:17:15"},{"activity":"memperbaharui plugin activity/activity.php menjadi 0","time":1360856568,"clock":"15:42:48"},{"activity":"memperbaharui plugin codemirror/codemirror.php menjadi 0","time":1360856568,"clock":"15:42:48"},{"activity":"memperbaharui plugin disk-memory-usage.php menjadi 0","time":1360856568,"clock":"15:42:48"},{"activity":"memperbaharui plugin timer.php menjadi 0","time":1360856568,"clock":"15:42:48"},{"activity":"memperbaharui plugin codemirror/codemirror.php menjadi 1","time":1360856574,"clock":"15:42:54"},{"activity":"memperbaharui plugin disk-memory-usage.php menjadi 1","time":1360856577,"clock":"15:42:57"}]', 'plugin', '2013-02-14'),
(6, 'admin', 'manager_options', '[{"activity":"mengubah settingan general option","time":1360853253,"clock":"14:47:33"},{"activity":"mengubah settingan general option","time":1360853258,"clock":"14:47:38"}]', 'setting', '2013-02-14'),
(7, 'admin', 'manager_options', '[{"activity":"mengubah settingan general option","time":1360981464,"clock":"02:24:24"},{"activity":"mengubah settingan general option","time":1360981484,"clock":"02:24:44"}]', 'setting', '2013-02-16'),
(8, 'admin', 'manager_options', '[{"activity":"mengubah settingan general option","time":1362079960,"clock":"19:32:40"}]', 'setting', '2013-02-28'),
(9, 'admin', 'post', '[{"activity":"mengubah status post 36 menjadi 0","time":1362148140,"clock":"14:29:00"},{"activity":"mengubah status post 36 menjadi 0","time":1362148191,"clock":"14:29:51"},{"activity":"mengubah status post 36 menjadi 0","time":1362148216,"clock":"14:30:16"},{"activity":"mengubah status post 36 menjadi 0","time":1362148227,"clock":"14:30:27"},{"activity":"mengubah status post 36 menjadi 0","time":1362148257,"clock":"14:30:57"},{"activity":"mengubah status post 36 menjadi 0","time":1362148305,"clock":"14:31:45"}]', 'post', '2013-03-01');

-- --------------------------------------------------------

--
-- Table structure for table `iw_stat_browse`
--

DROP TABLE IF EXISTS `iw_stat_browse`;
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
('browser', 'Opera#Mozilla Firefox#Galeon#Mozilla#MyIE#Lynx#Netscape#Konqueror#SearchBot#Internet Explorer 6#Internet Explorer 7#Internet Explorer 8#Internet Explorer 9#Internet Explorer 10#Other#', '1#12#0#140#0#0#0#0#0#0#0#0#0#0#0#'),
('os', 'Windows#Mac#Linux#FreeBSD#SunOS#IRIX#BeOS#OS/2#AIX#Other#', '153#0#0#0#0#0#0#0#0#0#'),
('day', 'Minggu#Senin#Selasa#Rabu#Kamis#Jumat#Sabtu#', '18#25#25#21#36#16#12#'),
('month', 'Januari#Februari#Maret#April#Mei#Juni#Juli#Agustus#September#Oktober#November#Desember#', '90#18#2#0#0#0#0#0#0#0#1#42#'),
('clock', '0:00 - 0:59#1:00 - 1:59#2:00 - 2:59#3:00 - 3:59#4:00 - 4:59#5:00 - 5:59#6:00 - 6:59#7:00 - 7:59#8:00 - 8:59#9:00 - 9:59#10:00 - 10:59#11:00 - 11:59#12:00 - 12:59#13:00 - 13:59#14:00 - 14:59#15:00 - 15:59#16:00 - 16:59#17:00 - 17:59#18:00 - 18:59#19:00 - 19:59#20:00 - 20:59#21:00 - 21:59#22:00 - 22:59#23:00 - 23:59#', '8#5#5#6#8#3#3#23#15#5#6#6#6#5#12#17#3#3#3#2#0#3#3#3#'),
('country', '#', '1#');

-- --------------------------------------------------------

--
-- Table structure for table `iw_stat_count`
--

DROP TABLE IF EXISTS `iw_stat_count`;
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
(1, '::1', 32, 913);

-- --------------------------------------------------------

--
-- Table structure for table `iw_stat_online`
--

DROP TABLE IF EXISTS `iw_stat_online`;
CREATE TABLE IF NOT EXISTS `iw_stat_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipproxy` varchar(100) DEFAULT NULL,
  `host` varchar(100) DEFAULT NULL,
  `ipanda` varchar(100) DEFAULT NULL,
  `proxyserver` varchar(100) DEFAULT NULL,
  `timevisit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1311 ;

--
-- Dumping data for table `iw_stat_online`
--

INSERT INTO `iw_stat_online` (`id`, `ipproxy`, `host`, `ipanda`, `proxyserver`, `timevisit`) VALUES
(1310, '127.0.0.1', 'azza-PC', '127.0.0.1', '', 1362160120);

-- --------------------------------------------------------

--
-- Table structure for table `iw_stat_onlineday`
--

DROP TABLE IF EXISTS `iw_stat_onlineday`;
CREATE TABLE IF NOT EXISTS `iw_stat_onlineday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipproxy` varchar(100) DEFAULT NULL,
  `host` varchar(100) DEFAULT NULL,
  `ipanda` varchar(100) DEFAULT NULL,
  `proxyserver` varchar(100) DEFAULT NULL,
  `timevisit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=230 ;

--
-- Dumping data for table `iw_stat_onlineday`
--

INSERT INTO `iw_stat_onlineday` (`id`, `ipproxy`, `host`, `ipanda`, `proxyserver`, `timevisit`) VALUES
(228, '::1', 'azza-PC', '::1', '', 1362157345),
(229, '127.0.0.1', 'azza-PC', '127.0.0.1', '', 1362160120);

-- --------------------------------------------------------

--
-- Table structure for table `iw_stat_onlinemonth`
--

DROP TABLE IF EXISTS `iw_stat_onlinemonth`;
CREATE TABLE IF NOT EXISTS `iw_stat_onlinemonth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipproxy` varchar(100) DEFAULT NULL,
  `host` varchar(100) DEFAULT NULL,
  `ipanda` varchar(100) DEFAULT NULL,
  `proxyserver` varchar(100) DEFAULT NULL,
  `timevisit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=133 ;

--
-- Dumping data for table `iw_stat_onlinemonth`
--

INSERT INTO `iw_stat_onlinemonth` (`id`, `ipproxy`, `host`, `ipanda`, `proxyserver`, `timevisit`) VALUES
(128, '::1', 'Azza-PC', '::1', '', 1362157345),
(132, '127.0.0.1', 'azza-PC', '127.0.0.1', '', 1362160120);

-- --------------------------------------------------------

--
-- Table structure for table `iw_stat_urls`
--

DROP TABLE IF EXISTS `iw_stat_urls`;
CREATE TABLE IF NOT EXISTS `iw_stat_urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(256) NOT NULL,
  `referrer` longtext NOT NULL,
  `search_terms` text NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '1',
  `date_modif` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `iw_users`
--

DROP TABLE IF EXISTS `iw_users`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `iw_users`
--

INSERT INTO `iw_users` (`ID`, `user_login`, `user_author`, `user_pass`, `user_email`, `user_sex`, `user_registered`, `user_last_update`, `user_activation_key`, `user_level`, `user_url`, `display_name`, `user_country`, `user_province`, `user_avatar`, `user_status`) VALUES
(1, 'admin', 'Eko Azza', '21232f297a57a5a743894a0e4a801fc3', 'admin@cmsid.org', 'l', '2010-03-02 13:09:37', '2013-03-01 17:48:57', '', 'admin', 'http://cmsid.org', 0, 'ID', 'Bandar Lampung', '20130121022320@57ab61ce05cf11e2bf7c22000a1e9ddc_7.jpg', 1),
(2, 'user', 'Example', 'ee11cbb19052e40b07aac0ca060c23ee', 'user@demo.com', 'l', '2010-08-04 09:06:13', '2013-02-10 10:15:46', '', 'user', '', 0, 'ID', 'Bandar Lampung', '', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
