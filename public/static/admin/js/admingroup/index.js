var app = new Vue({
    el: '#app-1',
    data: {
        page:1,
        pagestyle:0,
        title:'',
        stime:'',
        etime:'',
        limits:10,
        group_root:' ',
        lists:[],
        pagejump:0,
        taskinfo:[],
        sorts:'',

    },
    methods:{
        init:function(reset = false){       //重置
            if(reset){
                this.page = 1;
            }
           var loadindex = this.loads();
           _that = this;

           $.ajax({
               url:'/admingroup',
               data:{'page':_that.page,'limits':_that.limits,'title':_that.title,'stime':_that.stime,'etime':_that.etime,'group_root':_that.group_root,sorts:_that.sorts},
               type:'post',
               dataType:'json',
               success:function(e){
                   console.log(e);
                   _that.lists = e.data.data;
                   _that.pagestyle = e.data.datacount;

                    layer.close(loadindex);
               },
               error:function (e) {
                   layer.msg('系统繁忙，请稍后再试');
               }
           });
        },


        savename:function(id){
            var that = this;
            layer.prompt({title: '请输入新的领地名称', formType: 0}, function(pass, index){
                layer.close(index);
                that.loads();
                $.ajax({
                    url:'/savegroupname',
                    data:{'id':id,'name' : pass},
                    dataType:'json',
                    type:'post',
                    success:function(e)
                    {
                        if(e.code === 0){
                            layer.closeAll();
                            layer.msg(e.msg);
                            _that.init();
                        }else{
                            layer.closeAll();
                            layer.msg(e.msg);

                        }
                    }
                });
            });
        },
        setpage:function(num){
            var nowpage = this.page + num;
            if(nowpage > 0 && nowpage <= this.pagestyle){
                this.page+=num;
                this.init();
            }
        },
        jumppage:function()
        {
            if(parseInt(this.pagejump) > 0 && parseInt(this.pagejump) <= this.pagestyle){
                this.page = parseInt(this.pagejump);
                this.init();
            }else{
                layer.msg('请输入正确的页码');
            }
        },
        loads:function()
        {
            return layer.load(0, {
                shade: [0.2,'#000'] //0.1透明度的白色背景
            });
        },

    },
    created : function () {
        this.init();
    }

})

