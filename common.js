// 삭제 검사 확인
function del(href)
{
    if(confirm("Are you sure?\nit can't be recovered.")) {
        document.location.href = href;
    }    
}