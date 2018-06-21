$(function (){
	$('.btn_upload_image').click(function (){
		var original_send_attachment = wp.media.editor.send.attachment;
		var btn = $(this);
		wp.media.editor.send.attachment = function(prop, attachment){
			btn.parent().prev().attr('src', attachment.url);
			btn.prev().val(attachment.id);
			wp.media.editor.send.attachment = original_send_attachment;
		}
		wp.media.editor.open(btn);
		return false;
	});

	$('.btn_remove_image').click(function (){
		var btn = $(this);
		btn.parent().prev().attr('src', '');
		btn.prev().prev().val('');
		return false;
	});
});