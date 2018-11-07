<template>
    <div class="areaInfoContainer">
        <p>高速道路を選択してください</p>
        <select name="highway">
            <option value="1" v-model="highway_id">東名高速道路</option>
        </select>

        <p>SA, PAを選択してください</p>
        <p>
            <input type="radio" name="direction" id="up" value="1" v-model="direction_type">
            <label for="up">上り</label>
            <input type="radio" name="direction" id="down" value="2" v-model="direction_type">
            <label for="down">下り</label>
        </p>
        <select name="up_area" v-model="area_info_id" v-on:change="fetchStationInfo()" :disabled="direction_type==='2'">
            <option v-for="area in up_area_info" :value="area.id">{{ area.area_name }}</option>
        </select>

        <select name="down_area" v-model="area_info_id" v-on:change="fetchStationInfo()" :disabled="direction_type==='1'">
            <option v-for="area in down_area_info" :value="area.id">{{ area.area_name }}</option>
        </select>


        <div v-if="station_name!==''">
            <p v-if="is_anytime">営業時間：24時間営業</p>
            <p v-else>営業時間：{{ open_time }} 〜 {{ close_time }}</p>
        </div>

        <p>最寄り駅</p>
        <p>{{ station_name }}駅</p>
        <p>徒歩</p>
        <p>{{ time_required }}</p>
        <p>{{ distance }}</p>

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
                }).catch(res => {
                });
            },
            fetchStationInfo() {
                let apiName = 'get-station-info';

                axios.get('/' + apiName, {
                    params: {
                        area_info_id: this.area_info_id
                    }
                }).then((res) => {
                   this.station_name = res.data.station_name;
                   this.time_required = res.data.time_required;
                   this.distance = res.data.distance;
                   this.is_anytime = res.data.is_anytime;
                   this.open_time = res.data.open_time;
                   this.close_time = res.data.close_time;
                }).catch(res => {

                });
            },
            changeDirectionType() {
                console.log(this.direction_type);
            }
        }
    }
</script>
