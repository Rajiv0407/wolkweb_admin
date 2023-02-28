<ul>
                            <li><a href="javascript:void(0);" onclick="ajax_mailboxList(0)"><span><i class="bi bi-inbox"></i><span>Inbox</span></span><span class="iB_M" id="tInboxUnread">{{$totalInboxMssg}}</span></a></li>
                            <li><a href="javascript:void(0);" onclick="ajax_mailboxList(1)"><span><i class="bi bi-trash"></i><span>Trash</span></span><span class="iB_T">{{$totalTrashMssg}}</span></a></li>
                        </ul>