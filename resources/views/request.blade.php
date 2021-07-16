<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nepal Relief Fund</title>

    <link rel="stylesheet" href="/map-assets/css/bootstrap.css">

    <link rel="stylesheet" href="/map-assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/map-assets/css/owl.theme.default.min.css">

    <link rel="stylesheet" href="/map-assets/css/animate.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.css"  />

    <link rel="stylesheet" href="/map-assets/assets/fonts/Moderat/style.css">
    <link rel="stylesheet" href="/map-assets/assets/fonts/Proxima Nova/stylesheet.css">

    <link rel="stylesheet" href="/map-assets/css/reset.css">
    <link rel="stylesheet" href="/map-assets/css/style.css">
    <link rel="stylesheet" href="/map-assets/css/responsive.css">

    <style>
        #map-select {
                position: relative;
                top: 0;
                bottom: 0;
                width: 100%;
                height: 300px;
        }
    </style>

</head>

<body>

<header>
        <div class="container">
            <div class="header-wrap">
                <div class="header-logo">
                    <a href="index.html">
                        NEPAL RELIEF <span>PORTAL</span>
                    </a>
                </div>

                <div class="head-nav">
                    <a href="#section-map" class="active">Respond Maps</a>
                    <a href="#section-demographs">DEMOGRAPHICS</a>
                    <a href="#section-respond">Responds</a>
                </div>

                <div class="request">
                    <a href=""><ion-icon name="keypad-outline"></ion-icon> Request</a>
                </div>
            </div>
        </div>
    </header>


<section class="section-request" id="app">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="general-info">
                        <h5>General Information</h5>

                        <div class="user-type">
                            <p>
                                <input type="radio" id="individual" v-model="modelData.userType" name="user-type" value="individual">
                                <label for="individual">Individual</label>
                            </p>

                            <p>
                                <input type="radio" id="institution" v-model="modelData.userType" name="user-type" value="institution">
                                <label for="institution">Institution</label>
                            </p>
                        </div>

                        <div class="info-form" id="individual-form">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-card">
                                        <p>Full Name</p>
                                        <input type="text" v-model="modelData.individual.fullName">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-card">
                                        <p>Contact Number</p>
                                        <input type="number" v-model="modelData.individual.contactNumber">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-card">
                                        <p>Gender</p>
                                        <input type="text" v-model="modelData.individual.gender">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-card">
                                        <p>Age</p>
                                        <input type="number" v-model="modelData.individual.age">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="info-form" id="institution-form">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-card">
                                        <p>Organization's Name</p>
                                        <input type="text" v-model="modelData.institution.organizationName">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-card">
                                        <p>Organization's Type</p>
                                        <input type="text" v-model="modelData.institution.organizationType">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-card">
                                        <p>Organization's Address</p>
                                        <input type="text" v-model="modelData.institution.organizationAddress">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-card">
                                        <p>Contact Person</p>
                                        <input type="text" v-model="modelData.institution.contactPerson">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-card">
                                        <p>Contact Number</p>
                                        <input type="number" v-model="modelData.institution.contactNumber">
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="project-select">
                            <h5>Select Project</h5>

                            <div class="project-type">
                                @foreach($projects as $item)
                                <p>
                                    <input type="checkbox" id="{{ $item->title }}" name="project-type" v-model.number="modelData.projectType" value="{{ $item->id }}">
                                    <label for="{{ $item->title }}">{{ $item->title }}</label>
                                </p>
                                @endforeach
                            </div>
                            <h5>Request Date</h5>

                            <vuejs-datepicker v-model="modelData.requestDate"></vuejs-datepicker>

                            <div class="upload-doc" id="individualOxygen">
                                <h5>Request Date</h5>
                                <form action="/file-upload" class="dropzone">
                                    <div class="fallback">
                                      <input name="file" type="file" multiple />
                                    </div>
                                  </form>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-md-4">
                    <div class="location-info">
                        <h5>Relief Request Location</h5>

                        <div class="address-info-form" >
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="filter-card form-card">
                                        <p>Province</p>

                                        <select id="provinces">
                                            <option value="-1" selected disabled>Select Province</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="filter-card form-card">
                                        <p>District</p>

                                        <select id="districts">
                                            <option value="-1" selected disabled>Select District</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-card">
                                        <p>Local Address</p>
                                        <input type="text" v-model="modelData.localAddress">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-card location">
                                        <p>You can click on map to generate the location of your address</p>

                                        <div id="map-select"></div>
                                        <pre id="coordinates" class="coordinates"></pre>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div v-for="project in projectsWithInventories" class="item-listing">
                        <h5>@{{ project.title }}</h5>
                        <div v-for="inventoryItem in project.inventories" class="item-lists">
                            <p>
                                <input type="checkbox" :id="inventoryItem.title" v-on:click="checkItem(inventoryItem)" v-model="inventoryItem.checked" name="inventories" >
                                <label :for="inventoryItem.title">@{{ inventoryItem.title }}</label>
                            </p>

                            <p>
                                <label for="" class="label-small">Qty</label>
                                <input :disabled = "!inventoryItem.checked" type="text" v-model.number="inventoryItem.requestQuantity">
                            </p>

                            <p>
                                <label for="" class="label-small">Units</label>
                                <input :disabled = "!inventoryItem.checked" type="text" v-model.number="inventoryItem.units">
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">

                    <button class="btn btn-success" v-on:click="submit">Submit</button>
                </div>

            </div>
        </div>
    </section>

</body>
<script src="{{ asset('js/vue.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vuejs-datepicker/1.6.2/vuejs-datepicker.min.js" integrity="sha512-SxUBqfNhPSntua7WUkt171HWx4SV4xoRm14vLNsdDR/kQiMn8iMUeopr8VahPpuvRjQKeOiMJTJFH5NHzNUHYQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    class GetDefaultData {
        constructor(){
            this.data = {
                projects : @json($projects),
                modelData: {
                    userType: 'individual',
                    projectType: [],
                    requestDate: '',
                    district : 0,
                    province : 0,
                    localAddress: '',
                    coordinate:[],
                    individual:{
                        fullName: "",
                        contactNumber: "",
                        gender: "",
                        age: "",
                    },
                    institution: {
                        organizationName: "",
                        organizationType: "",
                        organizationAddress: "",
                        contactPerson: "",
                        contactNumber: "",
                    }
                }
            };
        }
    }
    var myInitial = new GetDefaultData();
    var myDynamic = new GetDefaultData();
    var app = new Vue({
            el: '#app',
            components: {
                vuejsDatepicker
            },
            data: myDynamic.data,
            computed:{
                projectsWithInventories : function() {
                    var tempthis = this;
                    return this.projects.filter(function(item){
                        return tempthis.modelData.projectType.includes(+item.id);
                    })
                }
            },
            watch:{
                'modelData.userType' :function(val){
                    if(val==='institution'){
                        this.modelData.individual = JSON.parse(JSON.stringify(myInitial.data.modelData.individual));
                    }
                    else if(val==='individual'){
                        this.modelData.institution = JSON.parse(JSON.stringify(myInitial.data.modelData.institution));
                    }
                }
            },
            methods:{
                customFormatter(date) {
                     return moment(date).format('m/d/Y g:i A');
                },
                submit(){
                    var formData = new FormData(); // Currently empty
                    formData.append('modelData', JSON.stringify(this.modelData));
                    formData.append('projectWithInventories', JSON.stringify(this.projectsWithInventories));
                    axios.post('{{ route("request") }}',formData)
                },
                getProvince(){
                    this.modelData.province = +document.getElementById('provinces').value;
                },
                getDistrict(){
                    this.modelData.district = +document.getElementById('districts').value;
                },
                setLongLat(long,lat){
                    this.modelData.coordinate = [long,lat];
                },
                checkItem(inventoryItem){
                    if(inventoryItem.checked){
                        inventoryItem.requestQuantity = null;
                        inventoryItem.units = null;
                    }
                }
            }
        });
</script>
<script src="/map-assets/js/jquery.min.js"></script>
    <script src="/map-assets/js/bootstrap.js"></script>
    <script src="/map-assets/js/owl.carousel.min.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<!--
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script> -->

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- <script src="/map-assets/js/chart.js"></script> -->

    <script>

var coordinates = document.getElementById('coordinates');
mapboxgl.accessToken = "pk.eyJ1IjoieW9nZXNoa2Fya2kiLCJhIjoiY2txZXphNHNlMGNybDJ1cXVmeXFiZzB1eSJ9.A7dJUR4ppKJDKWZypF_0lA";

var map = new mapboxgl.Map({
    container: "map-select",
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [84.0074, 28.4764],
    minZoom: 5, // note the camel-case
     maxZoom: 15
});

var marker = new mapboxgl.Marker({
draggable: true
})
.setLngLat([85.32399, 27.70254])
.addTo(map);

function onDragEnd() {
var lngLat = marker.getLngLat();
coordinates.style.display = 'block';
app.setLongLat(lngLat.lng,lngLat.lat);
coordinates.innerHTML =
'Longitude: ' + lngLat.lng + '<br />Latitude: ' + lngLat.lat;
}

marker.on('dragend', onDragEnd);

    map.addControl(
        new mapboxgl.GeolocateControl({
            positionOptions: {
            enableHighAccuracy: true
        },
        trackUserLocation: true
        })
    );

    </script>

    <script type="module" src="/map-assets/js/script.js"></script>
    <script type="module" src="/map-assets/js/request.js"></script>


<script type="module" src="{{ asset('js/custom.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.group').hide();
        $('#individual').show();
        $('#type').change(function() {
            $('.group').hide();
            $('#' + $(this).val()).show();
        })
    });
</script>
<!-- <script type="text/javascript">
    $(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-dd-mm'
        });
    });
</script> -->

<script>


var check = $("#individual").prop("checked");
if(check){
    $("#individual-form").addClass("activeTab");
}

$("#individual").on("click", function(){
    check = $(this).prop("checked");
    $("#institution-form").removeClass("activeTab");
    $("#individual-form").addClass("activeTab");

})

$("#institution").on("click", function(){
    check = $(this).prop("checked");
    $("#individual-form").removeClass("activeTab");
    $("#institution-form").addClass("activeTab");
})






</script>




</html>
