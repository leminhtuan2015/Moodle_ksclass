/**
 * Created by dddd on 12/25/16.
 */
var Ks = Ks || {};
Ks.testdb = Ks.testdb || {};
Ks.testdb.listTable = [];

Ks.testdb.init = function(){
    Ks.testdb.handler();
    $.ajax({url: "/moodle/koolsoft/testdb/rest/testdb_rest.php", success: function(results){
        var tables = JSON.parse(results);
        Ks.testdb.listTable = tables;
    }});
};

Ks.testdb.handler = function(){
    $("#btnCompare").click(function(){
        $.ajax({url: "/moodle/koolsoft/testdb/rest/testdb_rest.php", success: function(results){
            var tables = JSON.parse(results);
            var htmlResult = "";
            for(var i = 0; i < Ks.testdb.listTable.length; i++){
                tableNew = tables[i];
                var keyNews = Object.keys(tableNew);

                tableOld = Ks.testdb.listTable[i];
                var keyOlds = Object.keys(tableOld);

                if(tableNew[keyNews[0]] != tableOld[keyOlds[0]]){
                    htmlResult += keyNews[0] + "-- old: " + tableOld[keyOlds[0]] + " - new: " + tableNew[keyNews[0]] + "<br>";
                }
            }
            $("#result").html(htmlResult);

        }});
    });
};

$(function(){
    Ks.testdb.init();
});