// mixin에 사용할 코드들, app.js와 연결된 모든 곳에서 사용가능
export default {
    data() {
        return {

        }
    },
    methods: {
        async callApi(method, url, dataObj) {

            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj,
                });
            } catch (e) {
                return e.response;
            }

        },

        modalInfo(desc, title = "Hey") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        modalSuccess(desc, title = "Great") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        modalWarning(desc, title = "Oops!") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        modalError(desc, title = "Oops!") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        modalSwr(desc='Something went wrong', title = "Hey") {
            this.$Notice.error({
                title: title,
                desc: des
            });
        },

    },
}
