define([
    'ko',
    'uiComponent',
    'jquery',
], function (ko, Component, $) {
    'use strict';

    return Component.extend({
        default: {
            cities: []
        },
        data: {
            temperature: ko.observable(''),
            city: ko.observable(''),
            pressure: ko.observable(''),
            humidity: ko.observable('')
        },

        cityChange: ko.observable(0),
        selectedCity: '',
        selectedCountry: '',

        /** @inheritdoc */
        initialize: function () {
            this._super();
            if (this.cities.length > 0) {
                let item = this.cities[0];
                this.selectedCity = item['city'];
                this.selectedCountry = item['country'];
                this.loadData();
            }
            this.cityChange.subscribe(function(index) {
                let item = this.cities[index];
                this.selectedCity = item['city'];
                this.selectedCountry = item['country'];
                this.loadData();
            }, this);
        },

        getCities: function(){
            return this.cities;
        },

        loadData: function(){
            var self = this;

            $.ajax({
                url: '/rest/default/V1/weather/city/' + self.selectedCity + '/country/' + self.selectedCountry,
                type: "GET",
                dataType: 'json',
                success: function (result) {
                    if(result.length === 0){
                        return;
                    }
                    self.data.temperature(result.temperature);
                    self.data.pressure(result.pressure);
                    self.data.city(result.city);
                    self.data.humidity(result.humidity);
                }
            });
        }
    });
});
