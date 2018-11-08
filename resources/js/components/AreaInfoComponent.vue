<template>
    <div>
        <div class="header">
            <div class="head">
                <a href="/" class="logo">
                    <span>ニアステ</span>
                </a>
            </div>
            <div class="titleWord">
                <p>SA、PAで待ち合わせしたいけど、近くに駅ってあるのかな..?</p>
            </div>
        </div>

        <div class="explain">
            <div class="explainWord">
                <p>友達と車で旅行に行きたい！けど、家まで迎えに行くには高速を降りなきゃ。。</p>
                <p>SA（サービスエリア）やPA（パーキングエリア）で待ち合わせができたらなぁ〜</p>
                <p>さぁ、早速検索してみましょう！</p>
            </div>
        </div>

        <div class="contents">
            <section class="search">
                <div class="searchBox">
                    <div class="highwaySelect">
                        <div class="contentTitle">
                            <h1>高速道路</h1>
                        </div>
                        <div class="selectBox">
                            <select name="highway">
                                <option value="1" v-model="highway_id">東名高速道路</option>
                            </select>
                        </div>
                    </div>

                    <div class="areaSelect">
                        <div class="contentTitle">
                            <h1>方面、SA・PA</h1>
                        </div>
                        <div class="area">
                            <div class="upArea">
                                <input type="radio" name="direction" id="upDirection" value="1" v-model="direction_type">
                                <label for="upDirection">上り</label>
                                <select name="up_area" v-model="area_info_id" v-on:change="fetchStationInfo()" :disabled="direction_type==='2'">
                                    <option v-for="area in up_area_info" :value="area.id">{{ area.area_name }}</option>
                                </select>
                            </div>
                            <div class="downArea">
                                <input type="radio" name="direction" id="downDirection" value="2" v-model="direction_type">
                                <label for="downDirection">下り</label>
                                <select name="down_area" v-model="area_info_id" v-on:change="fetchStationInfo()" :disabled="direction_type==='1'">
                                    <option v-for="area in down_area_info" :value="area.id">{{ area.area_name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="result">
                <div class="areaName">
                    <h1>エリア名</h1>
                    <p v-if="station_name===''">-</p>
                    <p v-else>{{ area_name }}</p>
                </div>

                <div class="openTime">
                    <h1>営業時間</h1>
                    <p v-if="station_name===''">-</p>
                    <p v-else-if="is_anytime">24時間営業</p>
                    <p v-else>{{ open_time }} 〜 {{ close_time }}</p>
                </div>

                <div class="nearestStation">
                    <h1>最寄り駅</h1>
                    <p v-if="station_name===''">-</p>
                    <p>{{ station_name }}</p>
                </div>

                <div class="distance">
                    <h1>距離</h1>
                    <p v-if="station_name===''">-</p>
                    <p v-else>{{ area_name }}から{{ distance }}<br>
                        {{ time_required }}
                    </p>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                up_area_info: [],
                down_area_info: [],
                highway_id: 1,
                direction_type: '1',
                area_info_id: '',
                area_name: '',
                station_name: '',
                time_required: '',
                distance: '',
                is_anytime: true,
                open_time: '',
                close_time: ''
            }
        },
        mounted() {
            this.fetchAreaInfo();
        },
        methods: {
            fetchAreaInfo() {
                let apiName = 'get-area-info';

                axios.get('/' + apiName, {
                    params: {
                        highway_id: this.highway_id
                    },
                }).then((res) => {
                    this.up_area_info = res.data.up_area_info;
                    this.down_area_info = res.data.down_area_info;
                })
            },
            fetchStationInfo() {
                let apiName = 'get-station-info';

                axios.get('/' + apiName, {
                    params: {
                        area_info_id: this.area_info_id
                    }
                }).then((res) => {
                    this.area_name = res.data.area_name;
                    this.station_name = res.data.station_name;
                    this.time_required = res.data.time_required;
                    this.distance = res.data.distance;
                    this.is_anytime = res.data.is_anytime;
                    this.open_time = res.data.open_time;
                    this.close_time = res.data.close_time;
                })
            },
            changeDirectionType() {
                console.log(this.direction_type);
            }
        }
    }
</script>
