/**
| crypt.js
| Description:
|     . Cryption libraries to generate encrypted data and key to send to server
|
**/

(function (){
    app
        .service('CryptService', ['$http', function ($http) {
            var public_key = '-----BEGIN PUBLIC KEY-----\nMIIBITANBgkqhkiG9w0BAQEFAAOCAQ4AMIIBCQKCAQBkMthRH4PipOp4R12TItVu\nfrw7aJM6maHcceuHZACAERVzWvr6d+/Y7HBwgaHq4qZGaKY3aZ3hcmclgDrc8M5K\ne0E7rQ1158lROHSjj8IwHQvmdXBO0kjSLdEsY7yp8gfkm5/Rol5Wqvz/bO0xleHV\nu4p/MrFfXV/8PueCwfBTt6M5awxeq8xl0S++J6WVpNf5Cvr1WcqmHHC0GGVigaGS\nPt3bjz8dGZDa4dSOpQbzO/ibOhEFGDyevobPhtYxWQ/CK6Y1hRB2ih3p/Mvdkmbv\nqSJbI5RXY3PYzJ2iZTTevLt/GblrDiy0KKwQmRBz1oZpcTHVr6Pbhy4WvgyMVDjH\nAgMBAAE=\n-----END PUBLIC KEY-----';
            var public_method = {
                encryptKey: function (pass) {
                    var encrypt = new JSEncrypt();
                    encrypt.setPublicKey(public_key);
                    var encrypted = encrypt.encrypt(pass);

                    return encrypted;

                },
                generatePassword: function (length) {
                    length = length || 8;
                    var charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@!&%$#0123456789";
                    var retVal = "";
                    for (var i = 0, n = charset.length; i < length; ++i) {
                        retVal += charset.charAt(Math.floor(Math.random() * n));
                    }
                    return retVal;
                },
                encryptV2: function (text, pass) {
                    var encrypted = CryptoJS.AES.encrypt(text, pass);
                    return encrypted.toString();
                },

                decryptV2: function (text, pass) {
                    var decrypted = CryptoJS.AES.decrypt(text, pass);
                    return decrypted.toString(CryptoJS.enc.Utf8);
                },

                create: function (text, expired_in) {
                    var date = new Date();
                    var signature = date.getTime() + (expired_in * 1000 || (1000 * 60 * 10));
                    var pass = public_method.generatePassword(16);
                    text.signature = signature;
                    text = angular.isObject(text) ? angular.toJson(text) : text;
                    var en = public_method.encryptV2(text, pass);
                    var de = public_method.decryptV2(en, pass);
                    return {
                        pass: pass,
                        text: text,
                        encrypted: en,
                        decrypted: de,
                        encrypted_pass: public_method.encryptKey(pass)
                    };
                }
            };
            return public_method;
        }]);
}());