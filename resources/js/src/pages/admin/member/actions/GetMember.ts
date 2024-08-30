
export type GetMemberType = {
    data:{data:Array<{
        id:number,
        name:string,
        email:string
    }>}
} & Record<string, any>