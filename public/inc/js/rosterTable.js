var file;
var rows;

function handleFileSelect() {
    var fr = new FileReader();

    var x = document.getElementById('file');
    if ('files' in x) {
        if (x.files.length == 0) {
            alert('there are no files');
        } else {
            file = x.files[0];
            if ('name' in file) {
                $data = [];
                document.getElementById('fileName').setAttribute('value',file.name);

                fr.onload =(function(theFile) {
                    return function(e) {
                        rows = e.target.result.toString().split('\n');
                        var array = rows.toString().split(',');
                        for( var i= 0; i < rows.length-1;i++)
                        {
                            addRow(array[(4*i)], array[(4*i)+1], array[(4*i)+2], array[(4*i)+3],"row" + (i+1));
                        }

                      document.getElementById('filedata').setAttribute('value',array.toString());

                    };
                })(file);
                fr.readAsText(file);
            }
        }
    } else{
        if (x.value == "") {
            alert("Please select a file before clicking 'Load'");
        } else {
            alert("This browser doesn't seem to support the `files` property of file inputs.");
        }
    }
}

function addRow(firstName,lastName,id,email,rowNum)
{
    if (!document.getElementsByTagName) return;
    var  tabBody=document.getElementsByTagName("tbody").item(0);
    var row=document.createElement("tr");

    var cell1 = document.createElement("td");
    var cell2 = document.createElement("td");
    var cell3 = document.createElement("td");
    var cell4 = document.createElement("td");

    var textnode1=document.createTextNode(firstName);
    var textnode2=document.createTextNode(lastName);
    var textnode3=document.createTextNode(id);
    var textnode4=document.createTextNode(email);

    cell1.appendChild(textnode1);
    cell2.appendChild(textnode2);
    cell3.appendChild(textnode3);
    cell4.appendChild(textnode4);
    row.appendChild(cell1);
    row.appendChild(cell2);
    row.appendChild(cell3);
    row.appendChild(cell4);

    row.setAttribute('id',rowNum)
    tabBody.appendChild(row);
}

function deleteRoster(){

    var  tabBody=document.getElementsByTagName("tbody").item(0);
    for( var i= 0; i < rows.length-1;i++)
    {
        tabBody.removeChild(document.getElementById('row' + (i+1)));

    }
}

