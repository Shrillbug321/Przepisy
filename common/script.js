function redirect(page)
{
	location.href = page;
}

function add_row_to_table(tableName)
{
	var table = document.getElementById(tableName);
	console.log(table);
	var row = table.lastChild.lastChild;
	var clone = row.cloneNode(true);
	table.lastChild.appendChild(clone);
}

function remove_row_from_table(tableName)
{
	var table = document.getElementById(tableName);
	if (table.lastChild.childElementCount > 2) 
		table.lastChild.removeChild(table.lastChild.lastChild);
}