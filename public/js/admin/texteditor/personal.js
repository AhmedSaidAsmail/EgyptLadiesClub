$(document).ready(function(){
    
    
    $("#checkall").click(function(){
        
        
      $(this).closest("#emails_contains").find(":checkbox").prop('checked', this.checked);
        
        
        
    });
    
    
    
    
    
});