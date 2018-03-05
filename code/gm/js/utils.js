function isEmpty(str) {
    var reg = /^\s*$/i;
    return reg.test(str);
}
function floorNum(num) {
    return (Math.floor((parseFloat(num) * 100).toFixed(4)) / 100).toFixed(4);
}
