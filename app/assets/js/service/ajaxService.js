export const HttpServiceAyax = function() {};

HttpServiceAyax.prototype = {
    ajax: function(shippingFeatures) {
        const { method, url, contextType, data } = shippingFeatures;
        return new Promise((resolve, reject) => {
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = () => {
                const responseFeatures = { xhttp, resolve, reject };
                this.handleResponse(responseFeatures);
            };
            xhttp.open(method, url, true);
            xhttp.setRequestHeader('Content-type', contextType || 'application/json');
            xhttp.send(data || null);
        });
    },

    handleResponse: function(responseFeatures) {
        const { xhttp, resolve, reject } = responseFeatures;
        if (xhttp.readyState === XMLHttpRequest.DONE) {
            return this.isValid(xhttp)
                ? reject(new Error('failure in response'))
                : resolve(JSON.parse(xhttp.responseText));
        }
        return undefined;
    },

    isValid: xhttp => !(xhttp.status === 200),

    get: function(url, features = {}) {
        const shippingFeatures = { method: 'GET', url, ...features };
        return this.ajax(shippingFeatures);
    },

    post: function(url, features = {}) {
        const shippingFeatures = { method: 'POST', url, ...features };
        return this.ajax(shippingFeatures);
    },

    put: function(url, features = {}) {
        const shippingFeatures = { method: 'PUT', url, ...features };
        return this.ajax(shippingFeatures);
    },

    delete: function(url, features = {}) {
        const shippingFeatures = { method: 'DELETE', url, ...features };
        return this.ajax(shippingFeatures);
    },
};
