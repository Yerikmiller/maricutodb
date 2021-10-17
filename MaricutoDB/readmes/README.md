METHODS

Single Documents Method
The single file method contains all possible methods to create JSON files with data and which in turn can be passed sub-collections within their fields. Uses the same mechanism used by the previous version of MDB. You will be able to save approximately 50.000 documents/files without overloading the server.

Collections chunks method
This method saves a collection structure within files by parts, that is, it saves "documents" in a group of JSON files divided and which is managed by metadata. This method is for higher data volumes, you will be able to save approximately 300,000-500,000 documents without overloading the server, although if each document (array) created weighs a few KB and you establish a maximum number of parts or "documents" per file, higher than 1000, this limit can be extended to 1,500,000

1) <a href="https://github.com/Yerikmiller/maricutodb/tree/master/MaricutoDB/readmes/Documents%20Method">Single Documents - Documentation</a>
2) <a href="https://github.com/Yerikmiller/maricutodb/tree/master/MaricutoDB/readmes/Chunk%20Collections%20Method">Collections chunks - Documentation</a>