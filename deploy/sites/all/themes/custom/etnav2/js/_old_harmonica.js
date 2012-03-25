
// Evil
var area = null;
var curr_box = 0;
var box_width = 685;

function setRandomBox()
{
    /* Get random nmer between 1 and 3
     * TODO: Read why floor. Why round 
     * give werong distribution.     */
    curr_box = Math.floor(Math.random() * 3 + 1);

    area = $('#harmonica #show-area');

    // Damn, Opera!
    //$(area).scrollLeft(box_width * (box_num-1));
    $(area).animate({scrollLeft: box_width * (curr_box-1)}, 10);
}

function changeBox(box_num)
{
    $(area).animate({scrollLeft: box_width * (box_num-1)}, 300);
    curr_box = box_num;
}

function main()
{
    setRandomBox();
    var list = $('#harmonica #list-area');
    list.find('#item-' + curr_box).addClass('list-area-active-link');

    $(list).find('a').bind('click', 
        function()
        {  
            var box_num = $(this).parent().attr('id').substr(5, 6);
            list.find('#item-' + curr_box)
                .removeClass('list-area-active-link')
                .removeClass('list-area-hover-link');
            changeBox(box_num);
            list.find('#item-' + curr_box).addClass('list-area-active-link');
            return false;
        }
    );
    
    $(list).find('a').bind('mouseenter mouseleave',
        function()
        {
            $(this).parent().not('#item-' + curr_box).toggleClass('list-area-hover-link');
        }
    );      
}

Drupal.behaviors.harmonica = main;
//$(document).ready(main);
