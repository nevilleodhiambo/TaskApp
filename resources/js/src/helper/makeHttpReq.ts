
type HttpVerbType = 'GET' | 'POST' | 'PUT' | 'DELETE';

export function makeHttpReq<TInput, TResponse>
    (endpoint: string,
        verb: HttpVerbType,
        input: TInput
    ) {

    return new Promise<TResponse>(async (resolve, reject))=> {
        try {
            const res = await fetch(`${APP.apiBaseURL}/${endpoint}`, {
                method:verb,
                headers:{
                    "content-type": "application/json"
                    },
                    body: JSON.stringify(input)
        
            });

            const data:TResponse = await res.json();

            if(!res.ok){
                reject(data)
            }
            resolve(data)
            
        } catch (error) {
            reject(error);
        }
    });
}

function async(resolve: any, reject: any): (resolve: (value: TResponse | PromiseLike<TResponse>) => void, reject: (reason?: any) => void) => void {
    throw new Error("Function not implemented.");
}
