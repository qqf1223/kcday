/**
 * Created by qinqinfeng on 17/9/27.
 */
var valuetypestr = '<select name="valuetype" id="valuetype" class="form-control"><option value="">无</option><option value="list">list</option><option value="int">int</option><option value="string">string</option><option value="array">array</option><option value="obj">obj</option></select>';
function addNode(event){
    event.preventDefault();
    event.stopPropagation();
    currentNode = event.data.node;
    BootstrapDialog.show({
        title: '新增节点',
        message:$('<form class="form-horizontal"><div class="form-group"><label class="control-label col-md-3">父节点</label><div class="col-md-7"><input type="text" name="parent" class="form-control" value="'+currentNode.text+'" readonly /></div></div><div class="form-group"><label class="control-label col-md-3">新节点</label><div class="col-md-7"><input type="text" name="newnode" id="newnode" class="form-control" /></div></div><div class="form-group"><label class="control-label col-md-3">值类型</label><div class="col-md-7">'+valuetypestr+'</div></div></form>'),
        size:BootstrapDialog.SIZE_SMALL,
        buttons: [{
            id: 'saveNode',
            label: '保存',
            cssClass: 'btn-primary',
            action:function(dialogRef){ //new node
                var newval = dialogRef.getModalBody().find('#newnode').val();
                var valuetype = dialogRef.getModalBody().find('#valuetype').val();
                if(newval.trim() == ''){
                    BootstrapDialog.show({title:'提示',size:BootstrapDialog.SIZE_SMALL,message:'节点名称不能为空',type:BootstrapDialog.TYPE_WARNING});
                    return false;
                }
                var newNode = {
                    text: newval,
                    valuetype: valuetype,
                    selectable:false,
                };
                $('#tree').treeview('addNode', [newNode, currentNode]);
                dialogRef.close();
            }
        }]
    });
}
function editNode(event){
    event.preventDefault();
    event.stopPropagation();
    currentNode = event.data.node;
    var parentNodes = $('#tree').treeview('getParents', currentNode);
    if(parentNodes.length != 0) {
        parentNode = parentNodes[0];
    }else{
        parentNode = currentNode;
    }
    $('#editNewNode').val(currentNode.text);
    BootstrapDialog.show({
        title: '编辑节点',
        message:$('<form class="form-horizontal"><div class="form-group"><label class="control-label col-md-3">父节点</label><div class="col-md-7"><input type="text" name="parent" class="form-control" readonly value="'+parentNode.text+'"></div></div><div class="form-group"><label class="control-label col-md-3">名称</label><div class="col-md-7"><input type="text" name="newnode" id="newnode" class="form-control" value="'+currentNode.text+'" /></div></div><div class="form-group"><label class="control-label col-md-3">值类型</label><div class="col-md-7">'+valuetypestr+'</div></div></form>'),
        size:BootstrapDialog.SIZE_SMALL,
        buttons: [{
            id: 'updateNode',
            label: '保存',
            cssClass: 'btn-primary',
            action:function(dialogRef){ //new node
                var newval = dialogRef.getModalBody().find('#newnode').val();
                var valuetype = dialogRef.getModalBody().find('#valuetype').val();
                if(newval.trim() == ''){
                    BootstrapDialog.show({title:'提示',size:BootstrapDialog.SIZE_SMALL,message:'节点名称不能为空',type:BootstrapDialog.TYPE_WARNING});
                    return false;
                }
                var newNode = {
                    text: newval,
                    valuetype:valuetype,
                    selectable:false,
                };
                $('#tree').treeview('updateNode', [ currentNode, newNode, { silent: true } ]);
                dialogRef.close();
            }
        }]
    });
}
function removeNode(event){
    event.preventDefault();
    event.stopPropagation();
    currentNode = event.data.node;
    BootstrapDialog.confirm({
        title:'删除节点',
        size:BootstrapDialog.SIZE_SMALL,
        message: '确认要删除节点么?',
        callback: function(result){
            if(result) {
                $('#tree').treeview('removeNode', [currentNode, {silent: true}]);
            }
        }
    })
}

function showTree(rtype, data){
    $('body').append('<div id="tree"></div>');
    if(typeof data == 'undefined'){
        data = getTree();
    }
    $('#tree').treeview({
        data: data,
    });
    //显示树结构
    BootstrapDialog.show({
        title: rtype + '返回值格式',
        message: $('#tree'),
        buttons:[{
            label: '保存',
            cssClass: 'btn-primary',
            action:function(dialogRef){
                var data = $('#tree').treeview('getEnabled');
                console.log(data);
                $('#returnValue').val(JSON.stringify(data));
                dialogRef.close();
            }
        }]
    });
}
function getTree(){
    return [
        {
            text: "根",
            selectable:false,
        }
    ];
}