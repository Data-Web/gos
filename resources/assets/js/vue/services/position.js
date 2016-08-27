export default {
    setHttp (http) {
        this.http = http;
    },

    setRouter (router) {
        this.router = router;
    },

    index: function() {
        var self = this;
        
        return new Promise(function(resolve, reject) {
            self.http.get(self.router.route('api.v1.positions.index')).then(function (response) {
                resolve(response.data);
            }, function (response) {
                reject(response.data);
            });
        });
    },

    store: function(params) {
        var self = this;
        return new Promise(function(resolve, reject) {
            self.http.post(self.router.route('api.v1.positions.store'), params).then(function (response) {
                resolve(response.data);
            }, function (response) {
                reject(response.data);
            })
        })
    },

    edit: function(id) {
        var self = this;
        return new Promise(function(resolve, reject) {
            alert(id);
            self.http.get(self.router.route('api.v1.positions.edit', {positions: id})).then(function (response) {
                resolve(response.data);
            }, function (response) {
                reject(response.data);
            })
        })
    }
}
