@ApiResource(
*     collectionOperations={
*        "post" = {
*            "method"="POST",
*            "path"="admin/about",
*            "controller"=AboutPostAction::class,
*            "defaults"={"_api_receive"=false},
*         },
*         "get" = {
*             "path"="admin/about",
*             "method"="GET",
*         },
*     },
*     itemOperations={
*       "get" = {
*           "path"="admin/about/{id}",
*           "method"="GET",
*        },
*        "put" = {
*           "method"="PUT",
*           "path"="admin/about/{id}",
*           "controller"=AboutPutAction::class,
*           "defaults"={"_api_receive"=false},
*        },
*     },
* )