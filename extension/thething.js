function deepfryThemAll()
{
    return $('img').map(function () {
        let $this = $(this);
        let url = $(this).attr('src');

        if (url.substr(0,4) === 'data') {
            console.log('Base64 ' + url);
        } else {
            let objUrl = readUrl(url);
            if (isEmpty(objUrl)) {
                console.log('first two char: ' + url.substr(0,2));
                console.log(url);
                if (url.substr(0,2) === '//') {
                    url = url.substr(1);
                    console.log(url);
                    url = url.substr(1);
                    console.log('dropped  //: ' + url);
                    url = 'https://' + url;
                    console.log('added protocol: ' + url);
                    objUrl = readUrl(url);
                    console.log(objUrl);
                }
                if ( isEmpty(objUrl) ) {
                    console.log(isEmpty(objUrl) + ' ' + objUrl);
                    let urlWithHost = window.location + url;
                    console.log(urlWithHost);
                    objUrl = readUrl(urlWithHost);
                }

                if (isEmpty(objUrl)) {
                    console.log(url = 'IS UNMATCHABLE');
                }
            }
            if (!isEmpty(objUrl)) {
                console.log(objUrl.href);
                let imageArray = {
                    '0' : objUrl.href
                };
                try {
                    $.post("https://benjaminp.tech/deepfry/", JSON.stringify(imageArray))
                        .done(function (data) {
                            console.log(data);
                            if (data[0] != false) {
                                console.log('Replaced: '+ url);
                                $this.attr('src', data[0]);
                            }
                        });
                }catch(e) {
                    console.log(e);
                }
            }
        }
    });

}

let readyStateCheckInterval = setInterval(function() {
    if (document.readyState === "complete") {
        clearInterval(readyStateCheckInterval);
        deepfryThemAll();
    }
}, 10);


function readUrl(href) {
    let match = href.match(/^(https?\:)\/\/(([^:\/?#]*)(?:\:([0-9]+))?)([\/]{0,1}[^?#]*)(\?[^#]*|)(#.*|)$/);
    if (match != undefined) {
        return {
            href: href,
            protocol: match[1],
            host: match[2],
            hostname: match[3],
            port: match[4],
            pathname: match[5],
            search: match[6],
            hash: match[7]
        };
    } else {
        return undefined;
    }

}

function isEmpty(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}