function redirect(page)
{
	location.href = page;
}

function add_row_to_table(tableName)
{
	let table = document.getElementById(tableName);
	let row = table.lastChild.lastChild;
	let clone = row.cloneNode(true);
	table.lastChild.appendChild(clone);
}

function remove_row_from_table(tableName)
{
	let table = document.getElementById(tableName);
	if (table.lastChild.childElementCount > 2) 
		table.lastChild.removeChild(table.lastChild.lastChild);
}