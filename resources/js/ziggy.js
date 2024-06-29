const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"dashboard":{"uri":"dashboard","methods":["GET","HEAD"]},"users.search":{"uri":"users\/search","methods":["POST"]},"users.index":{"uri":"users\/index","methods":["POST"]},"users.update":{"uri":"users\/update\/{id}","methods":["PUT"],"parameters":["id"]},"users.delete":{"uri":"users\/delete\/{id}","methods":["DELETE"],"parameters":["id"]},"users.ban":{"uri":"users\/ban\/{id}","methods":["POST"],"parameters":["id"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
