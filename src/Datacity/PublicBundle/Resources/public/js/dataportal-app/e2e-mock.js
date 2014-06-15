angular
    .module('datacity.datasets.dev', [
        'datacity.datasets', 'ngMockE2E',
    ])
    .run(['$httpBackend',
        function($httpBackend) {
            datasets = [{
                slug: 'dataset-1',
                did: 1,
                name: 'Dataset1',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '9 Mars 2013',
                lastUpdate: '23 Mars 2014',
                user: 'Admin',
                location: 'France',
                type: 'dataset'
            }, {
                slug: 'dataset-2',
                did: 2,
                name: 'Dataset2',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                lastUpdate: '12 Avril 2014',
                user: 'Raphael',
                location: 'France',
                type: 'dataset'
            }, {
                slug: 'dataset-3',
                did: 3,
                name: 'Dataset3',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                lastUpdate: '5 Janvier 2014',
                user: 'Marc',
                location: 'France',
                type: 'dataset'
            }, {
                slug: 'dataset-4',
                did: 4,
                name: 'Dataset4',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '2 Avril 2014',
                lastUpdate: '2 Avril 2014',
                user: 'Cyril',
                location: 'Espagne',
                type: 'dataset'
            }, {
                slug: 'dataset-5',
                did: 5,
                name: 'Dataset5',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '1 Avril 2012',
                lastUpdate: '1 Avril 2012',
                user: 'Lionel',
                location: 'France',
                type: 'dataset'
            }, {
                slug: 'dataset-6',
                did: 6,
                name: 'Dataset6',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '3 Fevrier 2014',
                lastUpdate: '3 Fevrier 2014',
                user: 'Guillaume',
                location: 'Monde',
                type: 'dataset'
            }, {
                slug: 'dataset-7',
                did: 7,
                name: 'Dataset7',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '10 Juin 2014',
                lastUpdate: '10 Juin 2014',
                user: 'Cyntia',
                location: 'France',
                type: 'dataset'
            }, {
                slug: 'dataset-8',
                did: 8,
                name: 'Dataset8',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '12 Novembre 2013',
                lastUpdate: '12 Novembre 2013',
                user: 'Cedric',
                location: 'France',
                type: 'dataset'
            }, {
                slug: 'dataset-9',
                did: 9,
                name: 'Dataset9',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '14 Mai 2013',
                lastUpdate: '28 Septembre 2013',
                user: 'Ryan',
                location: 'France',
                type: 'dataset'
            }, {
                slug: 'dataset-10',
                did: 10,
                name: 'Dataset10',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '14 Novembre 2014',
                location: 'France',
                type: 'dataset'
            }, {
                slug: 'dataset-11',
                did: 11,
                name: 'Dataset11',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '5 Aout 2012',
                lastUpdate: '28 Septembre 2013',
                user: 'Ryan',
                type: 'dataset'
            }];
            sources = [{
                slug: 'source-1',
                sid: 1,
                name: 'Source1',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '22 Octobre 2012',
                lastUpdate: '23 Mars 2013',
                user: 'Admin',
                location: 'France',
                type: 'source',
                datasets: [datasets[0]]
            }, {
                slug: 'source-2',
                sid: 2,
                name: 'Source2',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '22 Juin 2013',
                lastUpdate: '12 Avril 2014',
                user: 'Raphael',
                location: 'France',
                type: 'source'
            }, {
                slug: 'source-3',
                sid: 3,
                name: 'Source3',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '20 Juin 2013',
                lastUpdate: '5 Janvier 2014',
                user: 'Marc',
                location: 'France',
                type: 'source'
            }, {
                slug: 'source-4',
                sid: 4,
                name: 'Source4',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '17 Fevrier 2014',
                lastUpdate: '2 Avril 2014',
                user: 'Cyril',
                location: 'Espagne',
                type: 'source'
            }, {
                slug: 'source-5',
                sid: 5,
                name: 'Source5',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '15 Mars 2012',
                lastUpdate: '1 Avril 2012',
                user: 'Lionel',
                location: 'France',
                type: 'source'
            }, {
                slug: 'source-6',
                sid: 6,
                name: 'Source6',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '28 Janvier 2014',
                lastUpdate: '3 Fevrier 2014',
                user: 'Guillaume',
                location: 'Monde',
                type: 'source'
            }, {
                slug: 'source-7',
                sid: 7,
                name: 'Source7',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '28 Decembre 2013',
                lastUpdate: '10 Juin 2014',
                user: 'Cyntia',
                location: 'France',
                type: 'source'
            }, {
                slug: 'source-8',
                sid: 8,
                name: 'Source8',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '28 Septembre 2013',
                lastUpdate: '12 Novembre 2013',
                user: 'Cedric',
                location: 'France',
                type: 'source'
            }, {
                slug: 'source-9',
                sid: 9,
                name: 'Source9',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '28 Septembre 2013',
                lastUpdate: '28 Septembre 2013',
                user: 'Ryan',
                location: 'France',
                type: 'source',
                datasets: [datasets[0]]
            }, {
                slug: 'source-10',
                sid: 10,
                name: 'Source10',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '28 Septembre 2013',
                location: 'France',
                type: 'source'
            }, {
                slug: 'source-11',
                sid: 11,
                name: 'Source11',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '28 Septembre 2013',
                lastUpdate: '28 Septembre 2013',
                user: 'Ryan',
                type: 'source'
            }];
            datasets[0].sources = [{
                slug: 'source-1',
                name: 'Source1',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '22 Octobre 2012',
                lastUpdate: '23 Mars 2013',
                user: 'Admin',
                location: 'France',
                type: 'source'
            }, {
                slug: 'source-9',
                name: 'Source9',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '28 Septembre 2013',
                lastUpdate: '28 Septembre 2013',
                user: 'Ryan',
                location: 'France',
                type: 'source'
            }];
            popularDatasets = [datasets[0], datasets[3], datasets[5], sources[0]];

            $httpBackend.whenGET('/ajax/popular-datasets').respond(popularDatasets);
            for (var i = datasets.length - 1; i >= 0; i--) {
                $httpBackend.whenGET('/ajax/dataset/' + datasets[i].slug).respond(datasets[i]);
            };
            for (var i = sources.length - 1; i >= 0; i--) {
                $httpBackend.whenGET('/ajax/source/' + sources[i].slug).respond(sources[i]);
            };
            $httpBackend.whenGET(/^\/partials\//).passThrough();
            $httpBackend.whenGET(/^http:\/\//).passThrough();
        }
    ]);
