class Reqist {
    constructor(url,complete) {
        let bz = this;
        this.name = 'graphicNAIVETY';
        this.counter = 1;
        this.url = url;
        this.completeURL = complete;
        this.submitter = $('.req-submitter');
        this.deleter = $('.req-deleter');
        this.steps = $('exo-sql-1-tab').length;
        this.submitter.on('click',function () {
            bz.send(bz.submitter);
        });
        this.deleter.on('click',function () {
            bz.clean(bz.submitter);
        });
        bz.init = function () {
            storage.clear();
            console.log(
                `%c ${this.name} %c version 1.0 %c`,
                'background:#35495e ; padding: 1px; border-radius: 3px 0 0 3px;  color: #fff',
                'background:#41b883 ; padding: 1px; border-radius: 0 3px 3px 0;  color: #fff',
                'background:transparent'
            );
            console.log('The awesome is running !');
        };
        bz.send = function (t, duplicate = null) {
            let container = t.parent().parent();
            let req = container.find('[name="request"]').val();
            //Check si la requête à chanée ou si elle est vide
            if (!bz.check(req) || req.trim() === '') return console.log('Already sent !');
            //Ajax -> PHP -> SQL
            $.post(bz.url, {
                request: req,
                exo: $('.nav-link.active').attr('data-value')
            }, function (data) {
                console.log('Request sent !');
                bz.result(data.win);
                let bgResult;
                let thead = $('#table-header');
                let tbody = $('#table-body');
                thead.html('');
                tbody.html('');
                if (data.response) {
                    let cols = Object.keys(data.response[0]);
                    for (let i = 0; i < cols.length; i++) {
                        let colName = cols[i];
                        thead.append(' <th scope="col" class="bg-light">' + colName + '</th>');
                    }
                    for (let j = 0; j < data.response.length; j++) {
                        let rows = Object.values(data.response[j]);
                        tbody.append('<tr id="row' + j + '" ></tr>');
                        for (let k = 0; k < rows.length; k++) {
                            $('#row' + j).append('<td style="overflow: hidden; text-overflow: ellipsis">' + rows[k] + '</td>');
                        }
                    }
                    bgResult = 'bg-success';
                } else {
                    console.log('Error ! Bad request...');
                    bgResult = 'bg-danger';
                    thead.append(' <th scope="row" class="bg-danger" style="width: 100vw"><i class="fas fa-exclamation-triangle text-warning"></i> &nbsp; ' + data.error + '</th>');
                }
                //On ajoute un bloc a l'historique uniquement si la requête est différente de la précèdente
                if (!duplicate && bz.check(req)) {
                    let savedRequest = container.clone();
                    savedRequest.find('.exercice').remove();
                    savedRequest.find('h4').remove();
                    savedRequest.find('hr').remove();
                    savedRequest.find('.form-req').toggleClass('col-6 col-12');
                    savedRequest.find('button.req-submitter').attr('onclick','reqist.send($(this),true)').append(' de nouveau');
                    savedRequest.find('textarea').attr('readonly', 'true').html(container.find('[name="request"]').val());
                    savedRequest.find('button.req-deleter').removeAttr('hidden').addClass('true');
                    $('#right-pane').append('<div class="rounded progress-bar-striped col-12 pt-3 pb-3 sql-form-ctn ' + bgResult + '">' + savedRequest.html() + '</div><hr>').find('textarea').click(function () {
                        bz.copy($(this))
                    });
                    console.log('Request added to History !');
                }
                bz.save(req);
            });
        };
        bz.save = function (req) {
            storage.setItem('lastReq', req);
            console.log('Request saved in local storage !');
        };
        bz.check = function (req) {
            let result = storage.getItem('lastReq') !== req;
            console.log("Sended request is a new one ? \r\n"+ result);
            return result;
        };
        bz.clean = function (e) {
            let elem = e.parent().parent('.sql-form-ctn');
            let req = elem.find('[name="request"]').val();
            if (!bz.check(req)) {
                storage.clear();
            }
            elem.next('hr').remove();
            elem.remove();
            console.log('Request removed from History !');
        };
        bz.copy = function (element) {
            let textZone = element.parent().parent().parent();
            textZone.addClass('copied');
            setTimeout(function () {
                textZone.removeClass('copied');
            }, 500);
            let $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
            console.log('Request copied to clipboard !');
        };
        bz.result = function (w) {
            console.log('Checking if you find the magic request...');
            if (w) {
                $('#overlay-win').removeClass('d-none').fadeOut(2000);
                setTimeout(function () {
                    $('#overlay-win').addClass('d-none').fadeIn();
                }, 2000);
                $('.nav-link.active').append('<i class="fas fa-thumbs-up text-warning float-right mt-1"></i>').addClass('finished').removeClass('active disabled').next('.nav-link:not(".active")').toggleClass('active disabled');
                $('.tab-pane.show.active').removeClass('show active').next('.tab-pane:not(".show.active")').addClass('show active');
                if(bz.counter === bz.steps) {
                    bz.complete();
                }
                bz.counter++;
                console.log('You find it ! Great job :');
            } else {
                console.log('Nope... Try again !');
            }
        };
        bz.complete = function () {
            $.post(bz.completeURL,function (data) {
                    if(data.response) {
                        window.location.href = $('.nav-link:eq(0)').attr('href');
                    }
            })
        }
    }
}