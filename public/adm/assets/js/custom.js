
/*Your custom script write here*/
function checkURL (item) {
    var string = item.value;
    if (!~string.indexOf("http")) {
        string = "http://" + string;
    }
    item.value = string;
    return item;
}

