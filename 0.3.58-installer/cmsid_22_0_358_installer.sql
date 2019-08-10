-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2013 at 02:05 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cmsid_22_0_358_installer`
--

-- --------------------------------------------------------

--
-- Table structure for table `iw_menu`
--

CREATE TABLE IF NOT EXISTS `iw_menu` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `class` varchar(255) NOT NULL DEFAULT '',
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `group_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `iw_menu`
--

INSERT INTO `iw_menu` (`id`, `parent_id`, `title`, `url`, `class`, `position`, `group_id`) VALUES
(1, 0, 'Home', './', 'home', 1, 1),
(2, 0, 'Home', './', '', 1, 2),
(3, 0, 'Contact', '#', '', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `iw_menu_group`
--

CREATE TABLE IF NOT EXISTS `iw_menu_group` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `iw_menu_group`
--

INSERT INTO `iw_menu_group` (`id`, `title`) VALUES
(1, 'Menu Utama'),
(2, 'Menu Header');

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
('template', 'inet'),
('sitename', 'Demo Situs'),
('sitedescription', 'Keterangan dari website'),
('sitekeywords', 'keyword website'),
('admin_email', 'id.hpaherba@yahoo.co.id'),
('site_public', '1'),
('site_charset', 'UTF-8'),
('siteurl', 'http://localhost/cmsid/build/0.3.58-installer'),
('active_plugins', '{"statistik-monitor.php":"0","phpids/phpids.php":"0","activity/activity.php":"0","seo-optimization/seo-optimization.php":"0","codemirror/codemirror.php":"0","disk-memory-usage.php":"0","rss-reader/rss-reader.php":"1"}'),
('siteslogan', 'slogan website'),
('avatar_default', 'mystery'),
('html_type', 'text/html'),
('menu-action', '[''aksi'':{''posts'':{''title'':''Post'',''link'':''?action=post''},''pages'':{''title'':''Pages'',''link'':''?action=pages''}}]'),
('timezone', 'Asia/Jakarta'),
('site_copyright', '2012 | CMS ID'),
('feed-news', '{"news_feeds":{"News Feed":"http://localhost/cmsid/server/2.1.4/rss.xml"},"display":{"desc":0,"author":0,"date":0,"limit":30}}'),
('datetime_format', 'Y/m/d'),
('date_format', 'F j, Y'),
('avatar_default', 'mystery'),
('author', 'admin'),
('post_comment', '1'),
('rewrite', 'advance'),
('body_layout', 'left'),
('dashboard_widget', '{"normal":"dashboard_update_info,dashboard_feed_news,dashboard_refering,","side":"dashboard_quick_post,dashboard_recent_registration,"}'),
('use_smilies', '1'),
('security_pip', '[{"file":"comment_on_post","ip":"::1","time":13604101830}]'),
('avatar_type', 'computer'),
('image_allaw', '{"image\\/png":".png","image\\/x-png":".png","image\\/gif":".gif","image\\/jpeg":".jpg","image\\/pjpeg":".jpg"}'),
('file_allaw', '["txt","csv","htm","html","xml","css","doc","xls","rtf","ppt","pdf","swf","flv","avi","wmv","mov","jpg","jpeg","gif","png"]'),
('sidebar_widgets', '{"sidebar-1":["meta","pages","archives"],"sidebar-2":["categories"]}'),
('account_registration', '1'),
('header-notif-x', '1'),
('jumpapp', '1');

-- --------------------------------------------------------

--
-- Table structure for table `iw_phpids`
--

CREATE TABLE IF NOT EXISTS `iw_phpids` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `page` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `impact` int(11) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `iw_post`
--

INSERT INTO `iw_post` (`id`, `user_login`, `date_post`, `title`, `content`, `mail`, `post_topic`, `hits`, `tags`, `sefttitle`, `type`, `status`, `thumb`, `thumb_desc`, `approved`, `meta_keys`, `meta_desc`) VALUES
(1, 'admin', '2013-03-22 06:42:55', 'Hallo Semua!', '<p>Selamat datang di CMS ID. Ini adalah tulisan pertama Anda. Sunting atau hapus, kemudian mulai membuat artikel!&nbsp;<span id="pastemarkerend">&nbsp;</span><br>\r\n\r\n</p>\r\n', 'id.hpaherba@yahoo.co.id', 1, 602, '', 'hallo-semua', 'post', 1, '', '', 1, '', ''),
(2, 'admin', '2000-07-19 00:00:00', 'Sample Page', '<p>Ini adalah contoh halaman. Yang berbeda dari tulisan karena\r\nakan menjadi satu kesatuan dan akan tampil pada menu navigasi situs (tema). Kebanyakan\r\norang memulai halamannya dengan menuliskan tentang mereka kenalkan ke\r\npengunjung situs. Kata katanya mungkin seperti ini:</p>\r\n\r\n\r\n<blockquote>Hi semua! Saya memiliki pesan hari ini, ini adalah situs\r\nsaya. Saya tinggal di Bandar Lampung, Indonesia, memiliki keluarga yang sangat\r\nhebat, memiliki kucing bernama Miaw, dan saya suka sekali dengan permainan bulu\r\ntangkis dan bola voli</blockquote>\r\n\r\nAtau bisa seperti ini:<br>\r\n\r\n\r\n<blockquote>Perusahaan tanpa nama XYZ didirikan pada tahun 1971, dan\r\ntelah menyediakan jasa informasi berkualitas kepada publik sampai saat ini. Terletak\r\ndi Kota Jakarta, XYZ memperkerjakan lebih dari 10000 karyawan dan melakukkan\r\nsegala macam hal yang mengagumkan bagi masyarakat sekitar.</blockquote>\r\n\r\n<p>Sebagai pengguna&nbsp;<a href="http://cmsid.org/">cmsid</a>&nbsp;yang baru, Anda harus pergi ke\r\ndashboard posting artikel untuk menghapus halaman ini dan mulai membuat halaman\r\nbaru untuk konten Anda. Have fun!. </p>\r\n', 'id.hpaherba@yahoo.co.id', 0, 0, '', 'sample-page', 'page', 1, '', '', 1, '', ''),
(3, 'admin', '2013-03-24 13:01:28', 'Support Us', '<p>Kelangsungan ketersediaan widget dan layanan web situs&nbsp;ini tergantung kepada bantuan dan dukungan dari anda. Banyak cara untuk mewujudkan dukungan tersebut.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Beritahu Yang Lain!</strong></p>\r\n<p>Silakan gunakan satu atau dua (atau lebih)&nbsp;pada situs atau blog yang anda punyai. Jika anda menggunakan&nbsp;twitter,&nbsp;atau tweet-ulang tulisan-tulisan kami. Jika anda adalah penggemar&nbsp;facebook, jadilah salah satu penggemar Halaman Fan kami ataupun juga jika anda menggunakan Goolgle+. Klik pada tombol&nbsp;Like&nbsp;pada kolom sisi kanan halaman ini.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Berikan Sumbangan!</strong></p>\r\n<p>Setiap sumbangsih finansial anda, sebesar apapun akan sangat berarti bagi pembayaran hosting situs dan pengelolaannya.</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>Donation bisa ditransfer ke rekening kami di:</p>\r\n<p><strong>BRI UNIT SIDOMULYO TELUK BETUNG&nbsp;</strong></p>\r\n<p><strong>No. Rek. 3562-01-016475-53-9&nbsp;</strong></p>\r\n<p><strong>a.n. Eko Hendratno</strong></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>Kami memohon kepada Allah atas petunjuk dan pertolongan-Nya serta limpahan rizqi yang terbaik.</p>', 'id.hpaherba@yahoo.co.id', 0, 0, '', 'support-us', 'page', 1, '', '', 1, '', ''),
(4, 'admin', '2013-03-24 15:14:46', 'Cerita dibalik pengembangan CMS ID v 2.2', '<p><span style="line-height: 1.5em;">CMS ID versi 2.2 adalah platform cms, pengembangan dari\r\ncmsid versi sebelumnya.</span><br>\r\n\r\n</p>\r\n\r\n<p>Cmsid pada versi ini sebagian merupakan platform cms code\r\nturunan dari codex wordpress dan digabungkan dengan platform cmsid itu sendiri\r\ndengan cita rasa kedua belah pihak kami selaku pengembang menggunakan hal hal\r\nyang ada platform cms tersebut untuk diterapkan pada cmsid versi ini.</p>\r\n\r\n<p>Cmsid versi ini sendiri merupakan versi yang beda dari versi\r\nversi sebelumnya dikarenakan kami melakukkan penelitian yang cukup panjang\r\nuntuk meneliti bagaimana sebuah platform cms popular saat ini yaitu wordpress\r\nitu bekerja, lalu kami menuangkannya pada cmsid versi baru ini,.. tentunya\r\ndengan beberapa sintax code yang kami bawa pada versi ini. Tapi tidak selamanya\r\nkami menggunakan syntax code itu suatu saat saat pengembangan cmsid lebih jauh\r\nmungkin cmsid akan mengadaptasikan synatax codenya sendiri cepat atau lambat.</p>\r\n\r\n<p>Kenapa kami memilih platform cms wordpress sebagain patner\r\ncodex, ini bukan lain ialah kemudahan pembuatan content yang lebih cepat dan\r\nmudah terutama dalam penggunaannya dengan begitu akan makin cepat dan mudah\r\ncontent akan tersaji untuk digunakan.</p>\r\n\r\n<p><b><br>\r\n\r\n</b></p>\r\n\r\n<p><b>Siapa saja dibalik pengembangan cmsid dan siapa siapa saja\r\nyang telah mendukung,..</b></p>\r\n<p><b><br>\r\n</b></p>\r\n\r\n<p>Saya akan menceritakan kembali sejarah cmsid,. CMS ID di\r\nkembangkan dan didirikan pada tahun 2010 tepatnya pada bulan april dahulu kala\r\ncmsid mesih belum menggunakan domain resmi cmsid.org dahulu domain name cmsid\r\nmasih menggunakan domain gratis yg banyak bertebaran diinternet&nbsp; sampai suatu saat ada supporter yg mendukung\r\ncmsid sampai saat ini, anda bisa cari dan lihat hostname dari cmsid itu sendiri\r\ndan tidak lain dan bukan ialah dutaspace.com lalu siapa dibalik dutaspace.com\r\nitu ialah Sdr.Hadi Mahmud ia adalah reseller hosting yg mendukung penuh cmsid\r\nsampai saat ini, lalu siapa juga yg dibalik pengembangan cmsid itu bukan lain\r\ndan bukan ialah Sdr. Eko seorang Mahasiswa Fakultas Teknik Informatik IBI\r\nDarmajaya Bandar Lampung serta teman teman yang telah memberikan kritik dan\r\nsarannya.</p>\r\n\r\n<p><b><br>\r\n\r\n</b></p>\r\n\r\n<p><b>Kemana arah cmsid itu,..?</b></p>\r\n<p><b><br>\r\n</b></p>\r\n\r\n<p>Yang pastinya cmsid ingin menjadi salah satu platform cms\r\nyang dicintai disisi penggunanya, cmsid&nbsp;\r\nakan selalu terus dan terus dikembangkan &nbsp;dan cmsid juga berencana ingin membuat sebuah produk\r\nbuku ulasan pengembangan cmsid dan waktunya tak dapat saya ditentukan sekarang,\r\nkarena ini merupakan kesiapan disisi penulisan saya, tapi rencana ini sudah\r\nsaya pikir matang matang untuk melaksanakannya, itupun kalau ada yg berkanan\r\nmencicipi buku ini,.. </p>\r\n\r\n<p>Baiklah itu adalah sepenggal cerita dari saya dibalik\r\npengembangan cmsid ini, jika ada saran dan kritik silahkan kirim ke form form\r\nyang kami sediakan bisa juga melalui forum&nbsp;\r\natau group group kami di fb: <a href="https://www.facebook.com/groups/cmsid/">https://www.facebook.com/groups/cmsid/</a> &nbsp;</p>\r\n\r\n<p>Jika anda salah satu yang berniat bergabung sebagai\r\npengembang atau supporter kami sailahkan hubungi saya di email:id.hpaherba@yahoo.co.id</p>\r\n\r\n<p>Itu sekian prakata dari saya kurang dan lebihnya saya mohon\r\nmaaf,.. salam id by eko</p>\r\n', 'id.hpaherba@yahoo.co.id', 1, 5, 'cerita, cmsid', 'cerita-dibalik-pengembangan-cms-id-v-2-2', 'post', 1, '', '', 1, '', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `iw_post_comment`
--

INSERT INTO `iw_post_comment` (`comment_id`, `comment`, `author`, `email`, `date`, `time`, `post_id`, `comment_parent`, `approved`, `user_id`) VALUES
(1, 'Hai, ini adalah komentar.<br />\r\nUntuk menghapus sebuah komentar, cukup masuk log dan lihat komentar tulisan tersebut. Di sana Anda akan memiliki pilihan untuk mengedit atau menghapusnya.', 'Eko Azza', 'id.hpaherba@yahoo.co.id', '2013-03-24 23:32:35', 1364167955, 1, 0, 1, 'admin');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `iw_post_topic`
--

INSERT INTO `iw_post_topic` (`id`, `topic`, `desc`, `public`, `status`) VALUES
(1, 'Sebuah kategori', 'Keterangan Sebuah kategori', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `iw_stat_activity`
--

CREATE TABLE IF NOT EXISTS `iw_stat_activity` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) NOT NULL,
  `activity_name` varchar(80) NOT NULL,
  `activity_value` longtext NOT NULL,
  `activity_img` text NOT NULL,
  `activity_date` date NOT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `iw_stat_activity`
--

INSERT INTO `iw_stat_activity` (`activity_id`, `user_id`, `activity_name`, `activity_value`, `activity_img`, `activity_date`) VALUES
(2, 'admin', 'manager_plugins', '[{"activity":"memperbaharui plugin activity/activity.php menjadi 0","time":1364135104,"clock":"14:25:04"}]', 'plugin', '2013-03-24');

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
('browser', 'Opera#Mozilla Firefox#Galeon#Mozilla#MyIE#Lynx#Netscape#Konqueror#SearchBot#Internet Explorer 6#Internet Explorer 7#Internet Explorer 8#Internet Explorer 9#Internet Explorer 10#Other#', '1#14#0#174#0#0#0#0#0#0#1397#1#1#0#0#'),
('os', 'Windows#Mac#Linux#FreeBSD#SunOS#IRIX#BeOS#OS/2#AIX#Other#', '1588#0#0#0#0#0#0#0#0#0#'),
('day', 'Minggu#Senin#Selasa#Rabu#Kamis#Jumat#Sabtu#', '243#28#29#26#38#20#1204#'),
('month', 'Januari#Februari#Maret#April#Mei#Juni#Juli#Agustus#September#Oktober#November#Desember#', '90#18#1437#0#0#0#0#0#0#0#1#42#'),
('clock', '0:00 - 0:59#1:00 - 1:59#2:00 - 2:59#3:00 - 3:59#4:00 - 4:59#5:00 - 5:59#6:00 - 6:59#7:00 - 7:59#8:00 - 8:59#9:00 - 9:59#10:00 - 10:59#11:00 - 11:59#12:00 - 12:59#13:00 - 13:59#14:00 - 14:59#15:00 - 15:59#16:00 - 16:59#17:00 - 17:59#18:00 - 18:59#19:00 - 19:59#20:00 - 20:59#21:00 - 21:59#22:00 - 22:59#23:00 - 23:59#', '8#7#6#8#10#5#5#24#20#104#6#121#271#6#12#205#319#3#3#2#0#3#8#432#'),
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
(1, '::1', 1398, 1603);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `iw_stat_online`
--

INSERT INTO `iw_stat_online` (`id`, `ipproxy`, `host`, `ipanda`, `proxyserver`, `timevisit`) VALUES
(42, '::1', 'Azza-PC', '::1', '', 1364173507);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `iw_stat_onlineday`
--

INSERT INTO `iw_stat_onlineday` (`id`, `ipproxy`, `host`, `ipanda`, `proxyserver`, `timevisit`) VALUES
(1, '::1', 'Azza-PC', '::1', '', 1364173507),
(2, '127.0.0.1', 'Azza-PC', '127.0.0.1', '', 1364168588);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `iw_stat_onlinemonth`
--

INSERT INTO `iw_stat_onlinemonth` (`id`, `ipproxy`, `host`, `ipanda`, `proxyserver`, `timevisit`) VALUES
(1, '::1', 'Azza-PC', '::1', '', 1364173507),
(2, '127.0.0.1', 'Azza-PC', '127.0.0.1', '', 1364168588);

-- --------------------------------------------------------

--
-- Table structure for table `iw_stat_urls`
--

CREATE TABLE IF NOT EXISTS `iw_stat_urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(256) NOT NULL,
  `referrer` longtext NOT NULL,
  `search_terms` text NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '1',
  `date_modif` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `iw_stat_urls`
--

INSERT INTO `iw_stat_urls` (`id`, `domain`, `referrer`, `search_terms`, `hits`, `date_modif`) VALUES
(1, 'localhost', 'http://localhost/cmsid/build/0.3.58-installer/?admin', '', 1, '2013-03-24 03:09:26');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `iw_users`
--

INSERT INTO `iw_users` (`ID`, `user_login`, `user_author`, `user_pass`, `user_email`, `user_sex`, `user_registered`, `user_last_update`, `user_activation_key`, `user_level`, `user_url`, `display_name`, `user_country`, `user_province`, `user_avatar`, `user_status`) VALUES
(1, 'admin', 'Eko Azza', '21232f297a57a5a743894a0e4a801fc3', 'id.hpaherba@yahoo.co.id', 'l', '2013-03-23 02:21:05', '2013-03-24 22:52:05', '', 'admin', '', 0, 'ID', '', '20130324030708@Picture0002.jpg', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
