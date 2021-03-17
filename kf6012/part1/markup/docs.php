<?php
    return "<div class='docbox'>
        <div class='docTitle'>1: Welcome</div>
            <div class='docEndPoint'><span class='underline'>/api/</span></div>
            <div class='docDesc'>Description: Welcome message to the API, and aviable endpoints</div>
            <div class='docAuth'>Authentication required: FALSE</div>
            <div class='docAuth'>Method: GET</div>
            <div class='Response'>Response
                <ul>
                    <li>message (string): human readable welcome message  </li>
                    <li>author (string): API authors name </li>
                    <li>avaiable Endpoints (array): list of avaible endpoints</li>
                </ul>
            </div>
            <p style='font-size: 150%;'> example: <a href='http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/'><span class='underline'>kf6012/part1/api/</span></a></p>
        </div>
    <div class='docbox' style='display: flex;'>
        <div class='docText'style='max-width: 50%;'>
            <div class='docTitle'>2: Authors</div>
            <div class='docEndPoint'><span class='underline'>/api/authors</span></div>
            <div class='docDesc'>Description: This endpoint will retirn a list of all the authors of CHI 2018</div>
            <div class='docAuth'>Authentication required: FALSE</div>
            <div class='docAuth'>Method: GET</div>
            <div class='Response'>Response:
                <ul>
                    <li>count (int): number of returend records  </li>
                    <li>data (array): containing the response data </li>
                    <li>  -authorId (int): ID number for the author</li>
                    <li>  -name (string): authors name </li>
                </ul>
            </div>
            <div class='Params'>Params:
                <ul>
                    <li>id (int, optional): the autor id  </li>
                    <li>search (string, optional): a search term for authors name </li>
                    <li>page (int, optional): page of results (10 results per page, ordered alphabetically) </li>
                </ul>
            </div>
            <p style='font-size: 150%;'> example: <a href='http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/authors'><span class='underline'>kf6012/part1/api/authors</span></a></p>
        </div>
    </div>
        <div class='docbox'>
            <div class='docTitle'>3: Author Presentations</div>
            <div class='docEndPoint'><span class='underline'>/api/authorPres</span></div>
            <div class='docDesc'>Description: Returns Details about all presentations a specified author is involved in</div>
            <div class='docAuth'>Authentication required: FALSE</div>
            <div class='docAuth'>Method: GET</div>
            <div class='Response'>Response
                <ul>
                    <li>status (string): HTTP status code  </li>
                    <li>count (int): number of records within [data]  </li>
                    <li>data (Array):  array of all responses  </li>
                    <li>data.AuthorID (string): Authors ID Number  </li>
                    <li>data.name (string): Authors name </li>
                    <li>data.abstract (string): abstract of the presentation</li>
                    <li>data.award (string)(optional): the award the paper has won (if applicable)</li>
                    <li>data.startHour (string): Hour of the day the presenation will start</li>
                    <li>data.startMinute(string): Minute of the hour the presentation will start</li>
                    <li>data.room Name (string): Name of the room of the presentation</li> 
                </ul>
                </div>
                <div class='Params'>Params:
                    <ul>
                        <li>search (string, optional): retrun authors where search term is wthin their name  </li>
                        <li>award (string, optional): return content that has won specified award (must exactly match BEST_PAPER or HONORABLE_MENTION )  </li>
                        <li>Page (int, optional): the page of the authors to be returned (10 results per page)  </li>
                    </ul>
                </div>
                <p style='font-size: 150%;'> example: <a href='http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/authorPres?search=A&page=1'><span class='underline'>kf6012/part1/api/authorPres?search=A&page=1</span></a></p>
        </div>
        <div class='docbox'>
            <div class='docTitle'>4: Sessions</div>
            <div class='docEndPoint'><span class='underline'>/api/sessions</span></div>
            <div class='docDesc'><b>Description:</b> Returns details for a session when given the session ID </div>
            <div class='docAuth'><b>Authentication required:</b> FALSE</div>
            <div class='docAuth'><b>Method:</b> GET</div>
            <div class='Response'><b>Response</b>
                <ul>
                    <li><b>status (string):</b> HTTP status code  </li>
                    <li><b>count (int):</b> number of records within [data]  </li>
                    <li><b>data (Array):</b>  array of all responses  </li>
                    <ul>
                        <li><b>Session Name:</b> name of the session</li>
                        <li><b>SessionId:</b> ID number for the session</li>
                        <li><b>Session Type:</b> type content for the session </li>
                        <li><b>Room Name:</b> Name of the room the session takes place in </li>
                        <li><b>startHour:</b> Hour of the day the session starts </li>
                        <li><b>startMinute:</b> minute of the hour the session starts </li>
                        <li><b>endHour:</b> Hour of the day the session ends </li>
                        <li><b>endMinute:</b> minute of the hour the session ends </li>
                        <li><b>Slot Type:</b> Type of slot that session has allocated </li>
                        <li><b>Session Chair:</b> Name of the chair for the session </li>
                    </ul>
                </ul>
                </div>
                <div class='Params'>Params:
                    <ul>
                        <li><b>Id</b> (int, Required): the session id  </li>
                    </ul>
                </div>
                <p style='font-size: 150%;'> example: <a href='http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/sessions?Id=2375'><span class='underline'>kf6012/part1/api/sessions?Id=2375</span></a></p>
        </div>
        <div class='docbox'>
            <div class='docTitle'>5: Presentations</div>
            <div class='docEndPoint'><span class='underline'>/api/presentations</span></div>
            <div class='docDesc'><b>Description:</b> Returns details of pressentations in each session including the title, authors, abstract and awards </div>
            <div class='docAuth'><b>Authentication required:</b> FALSE</div>
            <div class='docAuth'><b>Method:</b> GET</div>
            <div class='Response'><b>Response</b>
                <ul>
                    <li><b>status (string):</b> HTTP status code  </li>
                    <li><b>count (int):</b> number of records within [data]  </li>
                    <li><b>data (Array):</b>  array of all responses  </li>
                    <ul>
                        <li><b>title:</b> title of the presentation</li>
                        <li><b>abstract:</b> abstract of the paper from the presentation </li>
                        <li><b>award:</b> awards the paper has won (if any) </li>
                        <li><b>authors:</b> Authors of the presentation </li>
                        <li><b>sessionId:</b> Id number of the session the presentation will be in </li>
                    </ul>
                </ul>
                </div>
                <div class='Params'>Params:
                    <ul>
                        <li><b>id (int, Required):</b> the session id  </li>
                        <li><b>page (int, Optional):</b> page of returned data (pages of 10)  </li>
                    </ul>
                </div>
                <p style='font-size: 150%;'> example: <a href='http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/presentations?id=1914&page=3'><span class='underline'>kf6012/part1/api/presentations?id=1914&page=3</span></a></p>
        </div>
        <div class='docbox'>
        <div class='docTitle'>6: Authors Content</div>
        <div class='docEndPoint'><span class='underline'>/api/authorContent</span></div>
        <div class='docDesc'>Description: Returns details of the content for a specified author</div>
        <div class='docAuth'>Authentication Required: FALSE</div>
        <div class='docAuth'>Method: GET</div>
        <div class='Response'>Response
            <ul>
                <li>status (string): HTTP status code  </li>
                <li><b>count (int):</b> number of records within [data]  </li>
                <li><b>data (Array):</b>  array of all responses  </li>
                <ul>
                    <li><b>title:</b> title of the presentation</li>
                    <li><b>abstract:</b> abstract of the paper from the presentation </li>
                    <li><b>award:</b> awards the paper has won (if any) </li>
                    <li><b>startHour:</b> Hour of the day the content presentation begins </li>
                    <li><b>startMinute:</b> Minute of the hour the content presentation begins </li>
                    <li><b>endHour:</b> Hour of the day the content presentation ends</li>
                    <li><b>endMinute:</b> Minute of the hour the content presentation ends </li>
                    <li><b>name:</b> Name of the Author </li>
                    <li><b>auhtorId:</b> Id of the Author </li>
                    <li><b>roomName:</b> Name of the room the presentation is in </li>
                </ul>
            </ul>
            </div>
            <div class='Params'>Params:
                <ul>
                    <li>id (String, Optional): Id of the author to be searched - will return all records if left out </li>
                </ul>
            </div>
            <p style='font-size: 150%;'> example: <a href='http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/authorContent?id=8192'><span class='underline'>kf6012/part1/api/authorContent?id=8192</span></a></p>
    </div>
    <div class='docbox'>
        <div class='docTitle'>7: Slots</div>
        <div class='docEndPoint'><span class='underline'>/api/slots</span></div>
        <div class='docDesc'>Description: Returns time, location, day and type of a slot</div>
        <div class='docAuth'>Authentication Required: False</div>
        <div class='docAuth'>Method: GET</div>
        <div class='Response'>Response
            <ul>
                <li>status (string): HTTP status code  </li>
                <li><b>count (int):</b> number of records within [data]  </li>
                <li><b>data (Array):</b>  array of all responses  </li>
                <ul>
                    <li><b>slotID:</b> Id number of the Slot</li>
                    <li><b>Day:</b> Name of the day the slot is in </li>
                    <li><b>dayInt:</b> int value of day (e.g 2 = Tuesday) </li>
                    <li><b>Type:</b> Type of slot (session or break) </li>
                    <li><b>startHour:</b> Hour of the day the slot begins</li>
                    <li><b>startMinute:</b> Minute of the hour the slot begins </li>
                    <li><b>endHour:</b> Hour of the day the slot ends</li>
                    <li><b>endMinute:</b> Minute of the hour the ends </li>
                </ul>
            </ul>
            </div>
            <div class='Params'>Params:
                <ul>
                    <li>day (String, Optional): interger value of day (e.g 2 = Tuesday) </li>
                </ul>
            </div>
            <p style='font-size: 150%;'> example: <a href='http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/slots?day=2'><span class='underline'>/kf6012/part1/api/slots?day=2</span></a></p>
    </div>
    <div class='docbox'>
        <div class='docTitle'>8: Session Presentations</div>
        <div class='docEndPoint'><span class='underline'>/api/sessionpresentations</span></div>
        <div class='docDesc'>Description: Returns details of all presentatiosn within a specified session</div>
        <div class='docAuth'>Authentication Required: False</div>
        <div class='docAuth'>Method: GET</div>
        <div class='Response'>Response
            <ul>
                <li>status (string): HTTP status code  </li>
                <li><b>count (int):</b> number of records within [data]  </li>
                <li><b>data (Array):</b>  array of all responses  </li>
                <ul>
                    <li><b>title:</b> title of the presentation</li>
                    <li><b>abstract:</b> abstract description of the presentation </li>
                    <li><b>authors:</b> all auhtors involved in presentation </li>
                    <li><b>award:</b> award presentation has won (if any) </li>
                    <li><b>sessionId:</b> Id Number of the session the presentation is in</li>
                </ul>
            </ul>
            </div>
            <div class='Params'>Params:
                <ul>
                    <li>session_id (String, Required): Id number of session to search </li>
                </ul>
            </div>
            <p style='font-size: 150%;'> example: <a href='http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/sessionpresentations?session_id=2375'><span class='underline'>/kf6012/part1/api/sessionpresentations?session_id=2375</span></a></p>
    </div>
    <div class='docbox'>
        <div class='docTitle'>9: Login</div>
        <div class='docEndPoint'><span class='underline'>/api/login</span></div>
        <div class='docDesc'>Description: Validates login credentials with users in the database, returns JWT if successful</div>
        <div class='docAuth'>Authentication Required: TRUE</div>
        <div class='docAuth'>Method: POST</div>
        <div class='Response'>Response
            <ul>
                <li>status (string): HTTP status code  </li>
                <li>token (JWT):  Encoded JSON Web Token  </li>
                <ul>
                    <li>email (string): Email of user  </li>
                    <li>admin (int): If user has admin status  </li>
                    <li>iat (UnixTime Stamp): issued at time  </li>
                    <li>exp (UnixTime Stamp): expiry time (1 hour after issued at time)  </li>
                </ul>
                <li>admin (int): If user has admin status  </li>
            </ul>
            </div>
            <div class='Params'>Params:
                <ul>
                    <li>email (String, Required): Email of the user record </li>
                    <li>password (String, Required): String of the user record </li>
                </ul>
            </div>
            <p style='font-size: 150%;'> example: <span class='underline'>kf6012/part1/api/login</span></p>
    </div>
    <div class='docbox'>
        <div class='docTitle'>10: Add User</div>
        <div class='docEndPoint'><span class='underline'>/api/adduser</span></div>
        <div class='docDesc'>Description: used to add a new user to database when they signup (new users will be signed up as non-admins)</div>
        <div class='docAuth'>Authentication Required: FALSE</div>
        <div class='docAuth'>Method: POST</div>
        <div class='Response'>Response
            <ul>
                <li>status (string): HTTP status code </li>
                <li>message (String): human readable message if signup was successful or not </li>
            </ul>
            </div>
            <div class='Params'>Params:
                <ul>
                    <li>username (String, Required): username of new account to be made </li>
                    <li>email (String, Required): email fo new account to be made </li>
                    <li>password (String, Required): password for new account to be made </li>
                </ul>
            </div>
            <p style='font-size: 150%;'> example: <span class='underline'>kf6012/part1/api/adduser</span></p>
    </div>
    <div class='docbox'>
        <div class='docTitle'>11: Update</div>
        <div class='docEndPoint'><span class='underline'>/api/update</span></div>
        <div class='docDesc'>Description: updates title of presenataion if valid token is sent</div>
        <div class='docAuth'>Authentication Required: TRUE</div>
        <div class='docAuth'>Method: POST</div>
        <div class='Response'>Response
            <ul>
                <li>status (string): HTTP status code  </li>
                <li>message (String): mesage if request was sucessful or not </li>
                <li>(if sucessful)updated Id (String, Required): ID of the record that has been updated </li>
            </ul>
            </div>
            <div class='Params'>Params:
                <ul>
                    <li>title (String, Required): new title to update record </li>
                    <li>sessionId (String, Required): ID of the session to be updated </li>
                </ul>
            </div>
            <p style='font-size: 150%;'> example: <span class='underline'>kf6012/part1/api/update</span></p>
    </div>
    <div class='docbox'>
        <div class='docTitle'>12: Search</div>
        <div class='docEndPoint'><span class='underline'>/api/search</span></div>
        <div class='docDesc'>Description: used to add a new user to database when they signup (new users will be signed up as non-admins)</div>
        <div class='docAuth'>Authentication Required: FALSE</div>
        <div class='docAuth'>Method: GET</div>
        <div class='Response'>Response
            <ul>
                <li><b>status (string):</b> HTTP status code  </li>
                <li><b>count (int):</b> number of records within [data]  </li>
                <li><b>data (Array):</b>  array of all responses  </li>
                <ul>
                    <li><b>name (string):</b> name of author</li>
                    <li><b>title (string):</b> title of presentation</li>
                    <li><b>abstract (string):</b> abstract description for session </li>
                    <li><b>award (string):</b> awards won by presentation if any </li>
                    <li><b>contentId (string):</b> Id of the presentation  </li>
                </ul>
            </ul>
            </div>
            <div class='Params'>Params:
                <ul>
                    <li><b>name (string):</b> search term from author name</li>
                    <li><b>title (string):</b> search term from author title</li>
                    <li><b>page (INT):</b> page for returned data (10 results per page)</li>
                </ul>
            </div>
            <p style='font-size: 150%;'> example: <a href='http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/search?name=d&title=a&page=3'><span class='underline'>kf6012/part1/api/search?name=d&title=a&page=3</span></a></p>
    </div>
    <div class='docbox'>
        <div class='docTitle'>13: Error</div>
        <div class='docEndPoint'><span class='underline'>/api/error</span></div>
        <div class='docDesc'>Description: error message for incorect requests</div>
        <div class='docAuth'>Authentication Required: False</div>
        <div class='docAuth'>Method: GET</div>
        <div class='Response'>Response
            <ul>
                <li>status (string): HTTP status code  </li>
                <li>message: (string) message informing user of bad request  </li>
            </ul>
            <p style='font-size: 150%;'> example: <a href='http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/error'><span class='underline'>/kf6012/part1/api/error</span></a></p>
    </div>";
?>