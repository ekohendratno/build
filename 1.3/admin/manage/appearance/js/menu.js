jQuery(function($) {

	function site_url(url) {
		return BASE_URL + '/' + url;
	}
	/* highlight current menu group
	------------------------------------------------------------------------- */
	$('#menu-group li[id="group-' + current_group_id + '"]').addClass('current');

	/* edit menu
	------------------------------------------------------------------------- */
	$('.ns-actions .edit').live('click', function() {
		var menu_id = $(this).next().next().val();
		var menu_div = $(this).parent().parent();
		dialog.show({
			title: 'Edit Menu Item',
			type: 'ajax',
			url: site_url('?request&load=libs/ajax/menu.php&aksi=edit&id=' + menu_id),
			buttons: {
				'Save': function() {
					$.ajax({
						type: 'POST',
						url: $('#dialog_modal form').attr('action'),
						data: $('#dialog_modal form').serialize(),
						success: function(data) {
							switch (data.status) {
								case 1:
									dialog.hide();
									menu_div.find('.ns-title').html(data.menu.title);
									menu_div.find('.ns-url').html(data.menu.url);
									menu_div.find('.ns-class').html(data.menu.klass);
									break;
								case 2:
									dialog.hide();
									break;
							}
						}
					});
				},
				'Cancel': dialog.hide
			}
		});
		return false;
	});

	/* delete menu
	------------------------------------------------------------------------- */
	$('.ns-actions .delete').live('click', function() {
		var li = $(this).closest('li');
		var param = { id : $(this).next().val() };
		var menu_title = $(this).parent().parent().children('.ns-title').text();
		dialog.show({
			title: 'Delete Menu Item',
			content: '<div class="padding">Are you sure you want to delete this menu?<br><i>'
				+ menu_title +
				'</i><br><br>This will also delete all submenus under this menu.</div>',
			buttons: {
				'Yes': function() {
					$.post(site_url('?request&load=libs/ajax/menu.php&aksi=delete'), param, function(data) {
						if (data.status == 1) {
							dialog.hide();
							li.remove();
						} else {
							dialog.show({
								title: 'Delete Menu Item',
								content: '<div class="padding">Failed to delete this menu.</div>'
							});
						}
					});
				},
				'No': dialog.hide
			}
		});
		return false;
	});

	/* add menu
	------------------------------------------------------------------------- */
	$('#form-add-menu').submit(function() {
		if ($('#menu-title').val() == '') {
			$('#menu-title').focus();
		} else {
			$.ajax({
				title: 'Add Menu Item',
				type: 'POST',
				url: $(this).attr('action'),
				data: $(this).serialize(),
				error: function() {
					dialog.show({
						content: '<div class="padding">Add menu error. Please try again.</div>',
						autohide: 1000
					});
				},
				success: function(data) {
					switch (data.status) {
						case 1:
							$('#form-add-menu')[0].reset();
							$('#dragbox_easymn')
								.append(data.li)
							break;
						case 2:
							dialog.show({
								content: data.msg,
								autohide: 1000
							});
							break;
						case 3:
							$('#menu-title').val('').focus();
							break;
					}
				}
			});
		}
		return false;
	});

	$('#dialog_modal form').live('submit', function() {
		return false;
	});

	/* add menu group
	------------------------------------------------------------------------- */
	$('a#add-group').click(function() {
		dialog.show({
			title: 'Add Menu Group',
			type: 'ajax',
			url: $(this).attr('href'),
			buttons: {
				'Save': function() {
					var group_title = $('#menu-group-title').val();
					if (group_title == '') {
						$('#menu-group-title').focus();
					} else {
						
						//$('#gbox_ok').attr('disabled', true);
						$.ajax({
							type: 'POST',
							url: site_url('?request&load=libs/ajax/menu-group.php&aksi=add'),
							data: 'title=' + group_title,
							error: function() {
								//$('#gbox_ok').attr('disabled', false);
							},
							success: function(data) {
								//$('#gbox_ok').attr('disabled', false);
								switch (data.status) {
									case 1:
										dialog.hide();
										$('#menu-group').append('<li><a href="' + site_url('?admin&sys=appearance&go=menus&group_id=' + data.id) + '">' + group_title + '</a></li>');
										break;
									case 2:
										$('<span class="error"></span>')
											.text(data.msg)
											.prependTo('#dialog_modal_footer')
											.delay(1000)
											.fadeOut(500, function() {
												$(this).remove();
											});
										break;
									case 3:
										$('#menu-group-title').val('').focus();
										break;
								}
							}
						});
					}
				},
				'Cancel': dialog.hide
			}
		});
		return false;
	});

	/* edit group
	------------------------------------------------------------------------- */
	$('#edit-group').click(function() {
		var sgroup = $('#edit-group-input');
		var group_title = sgroup.text();
		sgroup.html('<input value="' + group_title + '" style="width:95%">');
		var inputgroup = sgroup.find('input');
		inputgroup.focus().select().keydown(function(e) {
			if (e.which == 13) {
				var title = $(this).val();
				if (title == '') {
					return false;
				}
				$.ajax({
					type: 'POST',
					url: site_url('?request&load=libs/ajax/menu-group.php&aksi=edit'),
					data: 'id=' + current_group_id + '&title=' + title,
					success: function(data) {
						if (data.status == 1) {
							sgroup.html(title);
							$('#group-' + current_group_id + ' a').text(title);
						}
					}
				});
			}
			if (e.which == 27) {
				sgroup.html(group_title);
			}
		});
		return false;
	});

	/* delete menu group
	------------------------------------------------------------------------- */
	$('#delete-group').click(function() {
		var group_title = $('#menu-group li.current a').text();
		var param = { id : current_group_id };
		dialog.show({
			title: 'Delete Menu Group',
			content: '<div class="padding">Are you sure you want to delete this group?<br><i>'
				+ group_title +
				'</i><br><br>This will also delete all menus under this group.</div>',
			buttons: {
				'Yes': function() {
					$.post(site_url('?request&load=libs/ajax/menu-group.php&aksi=delete'), param, function(data) {
						if (data.status == 1) {
							window.location = site_url('?admin&sys=appearance&go=menus');
						} else {
							dialog.show({
								content: '<div class="padding">Failed to delete this menu.</div>'
							});
						}
					});
				},
				'No': dialog.hide
			}
		});
		return false;
	});

});