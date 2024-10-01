$(function () {
  class GaugeChart {
      constructor(element, params) {
          this._element = element;
          this._initialValue = params.initialValue;
          this._higherValue = params.higherValue;
          this._title = params.title;
          this._subtitle = params.subtitle;
          this._startAngle = params.startAngle || 180;
          this._endAngle = params.endAngle || 360;
      }

      _buildConfig() {
          return {
              value: this._initialValue,
              valueIndicator: {
                  color: "#fff",
              },
              geometry: {
                  startAngle: this._startAngle,
                  endAngle: this._endAngle,
              },
              scale: {
                  startValue: 0,
                  endValue: this._higherValue,
                  customTicks: this._getCustomTicks(),
                  tick: {
                      length: 5,
                  },
                  label: {
                      font: {
                          color: "white",
                          size: 12,
                          family: '"Open Sans", sans-serif',
                      },
                  },
              },
              title: {
                  verticalAlignment: "bottom",
                  text: this._title,
                  font: {
                      family: '"Open Sans", sans-serif',
                      color: "#fff",
                      size: 0,
                  },
                  subtitle: {
                      text: this._subtitle,
                      font: {
                          family: '"Open Sans", sans-serif',
                          color: "#fff",
                          weight: 700,
                          size: 18,
                      },
                  },
              },
              onInitialized: function () {
                  let currentGauge = $(this._element);
                  currentGauge.find(".dxg-title text").first().attr("y", 48);
                  currentGauge.find(".dxg-title text").last().attr("y", 28);
              }.bind(this),
          };
      }

      _getCustomTicks() {
          if (this._title.includes("Degree")) {
              return [0, 45, 90, 135, 180, 225, 270, 315, 360];
          } else {
              return [0, 5, 10, 15, 20, 25, 30];
          }
      }

      init() {
          $(this._element).dxCircularGauge(this._buildConfig());
      }

      updateValue(value) {
          const gaugeInstance = $(this._element).dxCircularGauge("instance");
          if (gaugeInstance) {
              gaugeInstance.option("value", value);
              $(this._element)
                  .find(".dxg-title text")
                  .last()
                  .html(`${value} ${this._title.includes("knot") ? "knot" : "km/h"}`);
          } else {
              console.error("Gauge instance not found.");
          }
      }
  }

  $(document).ready(function () {
      let gauge1Params = {
          initialValue: 0,
          higherValue: 30,
          title: "Speed Over Ground (SOG) Knot",
          subtitle: "0 knot",
      };

      let gauge1 = new GaugeChart("#gauge1", gauge1Params);
      gauge1.init();

      let gauge2Params = {
          initialValue: 0,
          higherValue: 30,
          title: "Speed Over Ground (SOG) km/h",
          subtitle: "0 km/h",
      };

      let gauge2 = new GaugeChart("#gauge2", gauge2Params);
      gauge2.init();

      let gauge3Params = {
          initialValue: 0,
          higherValue: 360,
          title: "Course Over Ground (COG) Degree",
          subtitle: "0°",
          startAngle: 0,
          endAngle: 360,
      };

      let gauge3 = new GaugeChart("#gauge3", gauge3Params);
      gauge3.init();

      function updateGaugesFromFiles() {
          $.getJSON("SOGKnot.json", function (dataKnot) {
              if (dataKnot && dataKnot.value !== undefined) {
                  gauge1.updateValue(dataKnot.value);
              } else {
                  console.error("No data found or invalid data in SOGKnot.json.");
              }
          }).fail(function() {
              console.error("Failed to fetch SOGKnot.json.");
          });

          $.getJSON("SOGKm.json", function (dataKm) {
              if (dataKm && dataKm.value !== undefined) {
                  gauge2.updateValue(dataKm.value);
              } else {
                  console.error("No data found or invalid data in SOGKm.json.");
              }
          }).fail(function() {
              console.error("Failed to fetch SOGKm.json.");
          });

          // Uncomment and add file for COG if needed
          // $.getJSON("SOGDegree.json", function (dataDegree) {
          //     if (dataDegree && dataDegree.value !== undefined) {
          //         gauge3.updateValue(dataDegree.value);
          //     } else {
          //         console.error("No data found or invalid data in SOGDegree.json.");
          //     }
          // }).fail(function() {
          //     console.error("Failed to fetch SOGDegree.json.");
          // });
      }

      updateGaugesFromFiles();
  });
});





