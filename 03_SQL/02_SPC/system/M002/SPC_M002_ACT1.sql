IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M002_ACT1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M002_ACT1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M002_ACT1 '809','123','QuyPN','ユーザーカナ','QuyPN','34324234','234324234','quypn@ans-asia.com','1','1','809','M001','172.19.0.1';
--****************************************************************************************
--*   											
--*  処理概要/process overview	:	Insert or update data for user
--*  
--*  作成日/create date			:	2024/02/17
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M002_ACT1
	@P_user_cd						NVARCHAR(5)		= N''
,	@P_password						NVARCHAR(255)	= N''
,	@P_user_nm						NVARCHAR(30)	= N''
,	@P_user_kn_nm					NVARCHAR(30)	= N''
,	@P_user_ab_nm					NVARCHAR(30)	= N''
,	@P_tel							NVARCHAR(15)	= N''
,	@P_fax							NVARCHAR(15)	= N''
,	@P_mailaddress					NVARCHAR(255)	= N''
,	@P_belong_department_div		SMALLINT		= 0
,	@P_authority_div				SMALLINT		= 0
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
	-- variable general
		@w_time						DATETIME2		=	SYSDATETIME()
	,	@ERR_TBL					ERRTABLE
	-- variable log
    ,   @w_prs_mode					NVARCHAR(200)   =   N'Insert'
    ,   @w_prs_result				NVARCHAR(200)   =   N'OK'
	,	@w_remarks					NVARCHAR(200)	=	N''
	,	@w_table_key				NVARCHAR(200)	=	N'user_cd=' + @P_user_cd

	IF EXISTS(SELECT 1 FROM M002 WITH(NOLOCK) WHERE user_cd = @P_user_cd AND del_flg <> 1)
	BEGIN
		SET @w_prs_mode = 'Update'
	END

	-- START TRANSACTION 
	BEGIN TRANSACTION
	-- TRY CATCH EXCEPTION
	BEGIN TRY
		IF EXISTS(SELECT 1 FROM M002 WITH(NOLOCK) WHERE user_cd = @P_user_cd)
		BEGIN
			UPDATE M002 SET
				[password]				= @P_password
			,	user_nm					= @P_user_nm
			,	user_kn_nm				= @P_user_kn_nm
			,	user_ab_nm				= @P_user_ab_nm
			,	tel						= @P_tel
			,	fax						= @P_fax
			,	mailaddress				= @P_mailaddress
			,	belong_department_div	= @P_belong_department_div
			,	authority_div			= @P_authority_div
			,	cre_user_cd				= IIF(del_flg = 1, @P_act_user_cd,	cre_user_cd)
			,	cre_ip					= IIF(del_flg = 1, @P_ip,			cre_ip)
			,	cre_prg					= IIF(del_flg = 1, @P_prg,			cre_prg)
			,	cre_tm					= IIF(del_flg = 1, @w_time,			cre_tm)
			,	upd_user_cd				= IIF(del_flg = 1, NULL,			@P_act_user_cd)
			,	upd_ip					= IIF(del_flg = 1, NULL,			@P_ip)
			,	upd_prg					= IIF(del_flg = 1, NULL,			@P_prg)
			,	upd_tm					= IIF(del_flg = 1, NULL,			@w_time)
			,	del_user_cd				= NULL
			,	del_prg					= NULL
			,	del_ip					= NULL
			,	del_tm					= NULL
			,	del_flg					= 0
			WHERE
				user_cd					= @P_user_cd
		END
		ELSE
		BEGIN
			INSERT INTO M002
			SELECT
				@P_user_cd
			,	@P_password
			,	@P_user_nm
			,	@P_user_kn_nm
			,	@P_user_ab_nm
			,	@P_tel
			,	@P_fax
			,	@P_mailaddress
			,	@P_belong_department_div
			,	@P_authority_div
			,	NULL
			,	@P_act_user_cd
			,	@P_prg
			,	@P_ip
			,	@w_time
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	0
		END
	END TRY
	BEGIN CATCH
		SET @w_prs_result	=	'NG'
		SET @w_remarks		=	N'Error'                                                           + CHAR(13) + CHAR(10) +
								N'Procedure : ' + ISNULL(ERROR_PROCEDURE(), N'???')                + CHAR(13) + CHAR(10) +
								N'Line : '      + ISNULL(CAST(ERROR_LINE() AS NVARCHAR(10)), N'0') + CHAR(13) + CHAR(10) +
								N'Message : '   + ISNULL(ERROR_MESSAGE(), N'An unexpected error occurred.')
        DELETE FROM @ERR_TBL
        INSERT INTO @ERR_TBL
        SELECT  
            N'E009'
        ,   N''
        ,   0
        ,   999
        ,   0
		,	N''
        ,   @w_remarks
	END CATCH
    IF EXISTS (SELECT 1 FROM @ERR_TBL)
	BEGIN
		IF(@@TRANCOUNT > 0)
        BEGIN
            ROLLBACK TRANSACTION
        END
	END
	ELSE
	BEGIN
		DELETE FROM @ERR_TBL
		IF(@@TRANCOUNT > 0)
        BEGIN
            COMMIT TRANSACTION
        END
	END
    -- Insert statements for procedure here
	COMPLETE_QUERY:

	EXEC SPC_S999_ACT1
		@P_act_user_cd
	,	@P_prg
	,	@w_prs_mode
	,	@w_table_key
	,	@w_prs_result
	,	@w_remarks

	SELECT * FROM @ERR_TBL

END
GO
