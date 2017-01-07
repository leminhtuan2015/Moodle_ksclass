/**
 * Created by dddd on 12/29/16.
 */
var Singleton = (function () {
    var instance;

    function createInstance() {
        var object = new Object("I am the instance");
        return object;
    }

    return {
        getInstance: function () {
            if (!instance) {
                instance = createInstance();
            }
            return instance;
        }
    };
})();

$(function () {
    var instance1 = Singleton.getInstance();
    instance1.createInstance();
    var instance2 = Singleton.getInstance();

    alert("Same instance? " + (instance1 === instance2));
});
