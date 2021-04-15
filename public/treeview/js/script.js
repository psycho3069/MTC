// intialise all the treeView(s)
$('.treeview').treeView();
// handle expand and collapse buttons
$('.btn-expand').click(function () {
	$('.treeview').treeView('expandAll');
});
$('.btn-collapse').click(function () {
	$('.treeview').treeView('collapseAll');
})
