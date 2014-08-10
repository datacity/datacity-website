angular
    .module('datacity.dataset.dev', [
        'app', 'ngMockE2E',
    ])
    .run(['$httpBackend',
        function($httpBackend) {
            sources = [{
                sid: 1,
                name: 'Hôtels de Montpellier',
                date: '22 Octobre 2012',
                lastUpdate: '23 Mars 2013',
                user: 'Datacity',
                location: 'Montpellier',
                couverture: 'Commune'
            }, {
                sid: 2,
                name: 'Source2',
                date: '22 Juin 2013',
                lastUpdate: '12 Avril 2014',
                user: 'Raphael',
                location: 'Montpellier',
                couverture: 'Commune'
            }, {
                sid: 3,
                name: 'Source3',
                date: '20 Juin 2013',
                lastUpdate: '5 Janvier 2014',
                user: 'Marc',
                location: 'Montpellier',
                couverture: 'Commune'
            }, {
                sid: 4,
                name: 'Source4',
                date: '17 Fevrier 2014',
                lastUpdate: '2 Avril 2014',
                user: 'Cyril',
                location: 'Catalogne',
                couverture: 'Region'
            }, {
                sid: 5,
                name: 'Source5',
                date: '15 Mars 2012',
                lastUpdate: '1 Avril 2012',
                user: 'Lionel',
                location: 'Montpellier',
                couverture: 'Commune'
            }, {
                sid: 6,
                name: 'Source6',
                date: '28 Janvier 2014',
                lastUpdate: '3 Fevrier 2014',
                user: 'Guillaume',
                location: 'Toulouse',
                couverture: 'Commune'
            }, {
                sid: 7,
                name: 'Source7',
                date: '28 Decembre 2013',
                lastUpdate: '10 Juin 2014',
                user: 'Cyntia',
                location: 'Montpellier',
                couverture: 'Commune'
            }, {
                sid: 8,
                name: 'Source8',
                date: '28 Septembre 2013',
                lastUpdate: '12 Novembre 2013',
                user: 'Cedric',
                location: 'France',
                couverture: 'Pays'
            }, {
                sid: 9,
                name: 'Source9',
                date: '28 Septembre 2013',
                lastUpdate: '28 Septembre 2013',
                user: 'Ryan',
                location: 'Hérault',
                couverture: 'Département'
            }, {
                sid: 10,
                name: 'Source10',
                date: '28 Septembre 2013',
                user: 'User',
                location: 'Midi-Pyrénées',
                couverture: 'Région'
            }, {
                sid: 11,
                name: 'Source11',
                date: '13 Juillet 2012',
                lastUpdate: '4 Avril 2013',
                user: 'Ryan',
                location: 'Midi-Pyrénées',
                couverture: 'Région'
            }, {
                sid: 12,
                name: 'Hôtels de Toulouse',
                date: '16 Mars 2013',
                lastUpdate: '16 Mars 2013',
                user: 'Datacity',
                location: 'Toulouse',
                couverture: 'Commune'
            }, {
                sid: 13,
                name: 'Hôtels de Paris',
                date: '17 Mars 2013',
                lastUpdate: '17 Mars 2013',
                user: 'Datacity',
                location: 'Paris',
                couverture: 'Commune'
            }, {
                sid: 14,
                name: 'Hôtels de Bordeaux',
                date: '19 Mars 2013',
                lastUpdate: '19 Mars 2013',
                user: 'Datacity',
                location: 'Bordeaux',
                couverture: 'Commune'
            }, {
                sid: 15,
                name: 'Hôtels de Nantes',
                date: '22 Mars 2013',
                lastUpdate: '2 Avril 2013',
                user: 'Datacity',
                location: 'Nantes',
                couverture: 'Commune'
            }, {
                sid: 16,
                name: 'SourceE',
                date: '20 Fevrier 2014',
                lastUpdate: '20 Fevrier 2014',
                user: 'Cyril',
                location: 'Espagne',
                couverture: 'Pays'
            }];
            datasets = [{
                slug: 'hotels-de-france',
                did: 1,
                name: 'Hôtels de France',
                desc: 'Curabitur accumsan ligula quis ante tristique viverra. Fusce nec mauris tortor. Integer quis vulputate felis. Maecenas ultrices in felis ut tempus. Nunc feugiat adipiscing pellentesque. Duis laoreet, arcu nec egestas posuere, ligula velit vehicula sem, at tristique neque mi vel libero. Pellentesque augue metus, ultrices pellentesque vehicula ut, euismod at massa. Curabitur quis libero dignissim, luctus urna eu, accumsan ligula. Duis in felis a odio ultricies dignissim vel non lectus. Nulla at aliquet tellus, ut dictum diam. Vestibulum quam magna, mollis sit amet quam at, ultricies imperdiet sapien. Morbi viverra porttitor nisl, eget scelerisque dolor vestibulum ac. Aliquam sed quam vel nisi vehicula pharetra. Praesent euismod sapien sed diam imperdiet, a interdum lacus placerat.',
                date: '9 Mars 2013',
                lastUpdate: '23 Mars 2014',
                user: 'Datacity',
                location: 'Montpellier, Toulouse, Paris, Bordeaux, Nantes',
                couverture: 'Commune',
                sources: [sources[0], sources[11], sources[12], sources[13], sources[14]]
            }, {
                slug: 'dataset-2',
                did: 2,
                name: 'Dataset2',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                lastUpdate: '12 Avril 2014',
                user: 'Raphael',
                location: 'Montpellier',
                couverture: 'Commune',
                sources: [sources[1]]
            }, {
                slug: 'dataset-3',
                did: 3,
                name: 'Dataset3',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                lastUpdate: '5 Janvier 2014',
                user: 'Marc',
                location: 'Montpellier',
                couverture: 'Commune',
                sources: [sources[2]]
            }, {
                slug: 'dataset-4',
                did: 4,
                name: 'Dataset4',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '2 Avril 2014',
                lastUpdate: '2 Avril 2014',
                user: 'Cyril',
                location: 'Espagne, Catalogne',
                couverture: 'Pays',
                sources: [sources[3], sources[15]]
            }, {
                slug: 'velib-de-france',
                did: 5,
                name: 'Vélib de France',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '1 Avril 2012',
                lastUpdate: '1 Avril 2012',
                user: 'Lionel',
                location: 'France',
                couverture: 'Pays',
                sources: [sources[4]]
            }, {
                slug: 'dataset-6',
                did: 6,
                name: 'Dataset6',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '3 Fevrier 2014',
                lastUpdate: '3 Fevrier 2014',
                user: 'Guillaume',
                location: 'France, Canada',
                couverture: 'Monde',
                sources: [sources[5]]
            }, {
                slug: 'dataset-7',
                did: 7,
                name: 'Dataset7',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '10 Juin 2014',
                lastUpdate: '10 Juin 2014',
                user: 'Cyntia',
                location: 'France',
                sources: [sources[6]]
            }, {
                slug: 'dataset-8',
                did: 8,
                name: 'Dataset8',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '12 Novembre 2013',
                lastUpdate: '12 Novembre 2013',
                user: 'Cedric',
                location: 'France',
                sources: [sources[7]]
            }, {
                slug: 'dataset-9',
                did: 9,
                name: 'Dataset9',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '14 Mai 2013',
                lastUpdate: '28 Septembre 2013',
                user: 'Ryan',
                location: 'France',
                sources: [sources[8]]
            }, {
                slug: 'dataset-10',
                did: 10,
                name: 'Dataset10',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '14 Novembre 2014',
                user: 'User',
                location: 'Midi-Pyrénées',
                couverture: 'Région',
                sources: [sources[9]]
            }, {
                slug: 'dataset-11',
                did: 11,
                name: 'Dataset11',
                desc: 'Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.',
                date: '5 Aout 2012',
                lastUpdate: '28 Septembre 2013',
                user: 'Ryan',
                location: 'Midi-Pyrénées',
                couverture: 'Région',
                sources: [sources[10]]
            }];
            console.log("CALLED ! ");
            popularDatasets = [datasets[1], datasets[3], datasets[10], datasets[2], datasets[5]];

            $httpBackend.whenGET('/ajax/popular-datasets').respond(popularDatasets);
            for (var i = datasets.length - 1; i >= 0; i--) {
                $httpBackend.whenGET('/ajax/dataset/' + datasets[i].slug).respond(datasets[i]);
            };
            /*$httpBackend.whenGET(/^\/partials\//).passThrough();
            $httpBackend.whenGET(/^http:\/\//).passThrough();*/
        }
    ]);
